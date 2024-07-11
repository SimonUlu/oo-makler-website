<?php

namespace App\Services\OnOffice\Connectors;

use App\Models\SyncLogError;
use App\Services\Connector\AbstractApiConnector;
use App\Services\OnOffice;
use App\Services\OnOffice\Requests\Read\EstatePicture;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EstateConnector extends AbstractApiConnector
{
    public function search($apiConnectionId, $input, $searchCaseSensitive = false): array
    {
        $request = (new OnOffice\Requests\Search\Estate());

        $request->setInput($input);
        $request->setCaseSensitive($searchCaseSensitive);

        $response = $this->getApi()->send([$request]);

        // check if response has errors
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {
            // fill error into sync_log_errors
            $error = new SyncLogError();
            $error->api_connection_id = $apiConnectionId;
            $error->module = 'estate';
            $error->error = 'Read';
            $error->error_code = $response['response']['results'][0]['status']['errorcode'];
            $error->error_message = $response['response']['results'][0]['status']['message'];
            $error->error_data = ['request' => $request, 'respone' => $response];
            $error->save();
        }

        $records = $response['response']['results'][0];

        return $records ?? [];
    }

    public function create($params): array
    {
        $estate = (new OnOffice\Requests\Create\Estate());
        $estate->setData($params);
        $response = $this->getApi()->send($estate);

        return $response ?? [];
    }

    public function prepareFilterForOnOffice(string|array $values, $operator): array
    {
        return [
            'op' => $operator,
            'val' => $values,
        ];
    }

    public function update($recordId, $params): array
    {
        $estate = (new OnOffice\Requests\Edit\Estate($recordId));
        $estate->setData($params);
        $response = $this->getApi()->send([$estate]);

        return $response ?? [];
    }

    public function multiArrayKeyExists($key, $array)
    {
        // is in base array?
        if (array_key_exists($key, $array)) {
            return true;
        }

        // check arrays within the base array
        foreach ($array as $value) {
            if (is_array($value) && self::multiArrayKeyExists($key, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function createRelation(array $parentId, array $childId, string $relationType): array
    {
        $relation = (new OnOffice\Requests\Create\Relation(
            relationType: $relationType,
            parentIds: $parentId,
            childIds: $childId,
        ));

        $response = $this->getApi()->send($relation);
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {
            throw new Exception(json_encode($response));
        }

        return $response;
    }

    public function checkIfEstateExists($record, $uniqueFields)
    {
        if (empty($uniqueFields)) {
            return null;
        }
        // check if duplicateCheckAttributes are all in the keys of record
        $uniqueFieldscheck = collect($uniqueFields)->filter(function ($value, $key) use ($record) {
            return self::multiArrayKeyExists($key, $record);
        })->values()->toArray();

        if (count($uniqueFieldscheck) != count($uniqueFields)) {
            return null;
        }

        $estate = (new OnOffice\Requests\Read\Estate());
        foreach (array_keys($uniqueFields) as $filterItem) {
            collect($record)->filter(function ($value, $key) use ($filterItem, $estate) {
                //get first dimension of array
                if (
                    $filterItem === $key
                ) {
                    // if key is Email, make it lowercase
                    $estate->setFilter($key, [self::prepareFilterForOnOffice([$value], 'IN')]);
                }
            });
        }

        $result = $this->getApi()->send([$estate]);

        if ($result['response']['results'][0]['status']['errorcode'] != 0) {
            throw new Exception(json_encode($result));
        }

        return $result['response']['results'][0]['data']['records'][0] ?? null;
    }

    public function uploadFileTmp($record): ?string
    {
        $requests = [];
        $imagePath = $record['imagePath'];

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            $file = Arr::last(explode('/', $imagePath));
            $newPath = storage_path('app/tmp/'.$file);

            // Make the directory if it doesn't exist.
            $directoryPath = storage_path('app/tmp/');
            if (! Storage::exists($directoryPath)) {
                Storage::makeDirectory($directoryPath, 0755, true);
            }

            file_put_contents($newPath, file_get_contents($imagePath));
            $imagePath = $newPath;
        } else {
            $file = Arr::last(explode('/', $imagePath));
        }

        if (! isset($file) || ! isset($imagePath)) {
            return null;
        }

        $uploadFile = (new OnOffice\Requests\Do\UploadFile());
        $uploadFile->setFileData($file, base64_encode(file_get_contents($imagePath)));
        $requests[] = $uploadFile;

        $response = $this->getApi()->send($requests);
        if (! empty($response)) {
            return $response['response']['results'][0]['data']['records'][0]['elements']['tmpUploadId'];
        } else {
            Log::info('Error while uploading file to onOffice');
        }
    }

    public function getEstateImages($recordId, $categories): array
    {
        $request = new EstatePicture();
        $request
            ->setEstateIds([$recordId])
            ->setCategories($categories);

        $response = $this->getApi()->send([$request]);

        // check if response has errors
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {
            // fill error into sync_log_errors
            //TODO: make onOffice error entry log (in collection)
        }

        return $response['response']['results'][0];
    }

    public function uploadFile($imageParams, $resourceId): ?string
    {
        $uploadFile = (new OnOffice\Requests\Do\UploadFile());
        $uploadFile->setModuleData(
            tmpUploadId: $imageParams['tmpUploadId'],
            file: $imageParams['file'],
            title: $imageParams['title'],
            art: $imageParams['type'],
            relatedRecordId: $resourceId,
            module: $imageParams['module'],
        );

        $response = $this->getApi()->send($uploadFile);
        // Defining maximum retries and initial delay

        return $response['response']['results'][0]['data']['records'][0]['elements']['fileId'] ?? -1;
    }

    public function getOnOfficeFields(): array
    {
        $api = $this->getApi();

        return self::getEstateFields($api);
    }

    public function deleteImage($recordId, $imageId): void
    {
        $deleteFile = (new OnOffice\Requests\Delete\File(
            fileId: $imageId,
            parentId: $recordId,
            relationType: 'estate'
        ));

        $response = $this->getApi()->send($deleteFile);
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {
            throw new Exception(json_encode($response));
        }
    }

    public function getRecord(
        $filter = null,
        $resourceId = null,
        array $params = ['objektnr_extern'],
        $offset = 0,
        $limit = 500,
        $sortBy = null
    ): ?array {
        $request = (new OnOffice\Requests\Read\Estate());
        if ($resourceId) {
            $request->setRecordIds([$resourceId]);
        }
        if ($filter) {
            $request->setFilter(
                $filter['field'],
                [self::prepareFilterForOnOffice(
                    [$filter['value']],
                    $filter['operator'] ?? 'IN'
                )]
            );
        }

        do {
            $request->setOffset($offset);
            $request->setLimit($limit);
            $request->setData($params);
            if (isset($sortBy)) {
                $request->setSortBy(array_key_first($sortBy), $sortBy[array_key_first($sortBy)]);
            }
            $response = $this->getApi()->send([$request]);
            if (! isset($records)) {
                $records = $response['response']['results'][0]['data']['records'];
            } else {
                $records = array_merge($records, $response['response']['results'][0]['data']['records']);
            }
            $offset += $limit;
        } while (count($response['response']['results'][0]['data']['records']) == $limit && $limit != 1);

        return $records ?? [];
    }

    public function getRecordChunk(
        $filters = null,
        $resourceId = null,
        array $params = ['id'],
        $offset = 0,
        $limit = 500,
        $sortBy = ['geaendert_am' => 'ASC']
    ): ?array {
        $request = (new OnOffice\Requests\Read\Estate());
        if ($resourceId) {
            $request->setResourceId($resourceId);
        }

        foreach ($filters as $key => $filter) {
            $request->setFilter(
                $key, $filter
            );
        }

        $request->setOffset($offset);
        $request->setLimit($limit);
        $request->setData($params);

        if (isset($sortBy)) {
            $request->setSortBy(array_key_first($sortBy));
            $request->setSortOrder($sortBy[array_key_first($sortBy)]);
        }

        $response = $this->getApi()->send([$request]);

        // check if response has errors
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {
            // fill error into sync_log_errors
            //TODO: make onOffice error entry log (in collection)
        }

        return $response['response']['results'][0];
    }

    public function getBuyer(
        $apiConnectionId,
        $resourceId,
    ): ?array {
        $request = (new OnOffice\Requests\Read\EstateBuyer());
        if ($resourceId) {
            $request->setParentIds($resourceId);
        }

        $response = $this->getApi()->send([$request]);

        // check if response has errors
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {

            // fill error into sync_log_errors
            $error = new SyncLogError();
            $error->api_connection_id = $apiConnectionId;
            $error->module = 'estate';
            $error->error = 'Read';
            $error->error_code = $response['response']['results'][0]['status']['errorcode'];
            $error->error_message = $response['response']['results'][0]['status']['message'];
            $error->error_data = ['request' => $request, 'respone' => $response];
            $error->save();
        }

        $records = $response['response']['results'][0];

        return $records ?? [];
    }

    public function getSeller(
        $apiConnectionId,
        $resourceId,
    ): ?array {
        $request = (new OnOffice\Requests\Read\EstateSeller());
        if ($resourceId) {
            $request->setParentIds($resourceId);
        }

        $response = $this->getApi()->send([$request]);

        // check if response has errors
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {

            // fill error into sync_log_errors
            $error = new SyncLogError();
            $error->api_connection_id = $apiConnectionId;
            $error->module = 'estate';
            $error->error = 'Read';
            $error->error_code = $response['response']['results'][0]['status']['errorcode'];
            $error->error_message = $response['response']['results'][0]['status']['message'];
            $error->error_data = ['request' => $request, 'respone' => $response];
            $error->save();
        }

        $records = $response['response']['results'][0];

        return $records ?? [];
    }

    /**
     * @throws Exception
     */
    public function updateOrCreate($record, $uniqueFields, $doNotUpdate = null): array
    {
        $api = $this->getApi();
        $onOfficeFieldsRaw = self::getEstateFields($api);

        // check if estate exists in onOffice
        $estateData = self::checkIfEstateExists($record, $uniqueFields);
        $estateId = $estateData['id'] ?? null;

        if ($estateId) {
            $estate = (new OnOffice\Requests\Edit\Estate($estateId));
            // prepare the params for the request
            $params = self::checkMultiselectFields($record, $onOfficeFieldsRaw, $estateId);
            $params = self::removeUniqueFieldsFromParams($params, $uniqueFields, $onOfficeFieldsRaw);
        } else {
            $estate = (new OnOffice\Requests\Create\Estate());

            $params = self::checkForSpecialCaseCreate(array_filter($record));
        }

        // if params has 'image' unset it
        $notAllowedParams = ['images', 'isspecialcondition'];

        foreach ($notAllowedParams as $index) {
            if (isset($params[$index])) {
                unset($params[$index]);
            }
        }

        // remove $doNotUpdate fields from params if set
        if (isset($doNotUpdate)) {
            foreach ($doNotUpdate as $index) {
                if (isset($params[$index])) {
                    unset($params[$index]);
                }
            }
        }

        // if params has 'image' unset it
        $notAllowedParams = ['images', 'isspecialcondition', 'description', 'pictures', 'anhaenge'];

        foreach ($notAllowedParams as $index) {
            if (isset($params[$index])) {
                unset($params[$index]);
            }
        }

        // remove $doNotUpdate fields from params if set
        if (isset($doNotUpdate)) {
            foreach ($doNotUpdate as $index) {
                if (isset($params[$index])) {
                    unset($params[$index]);
                }
            }
        }

        $estate->setData($params);
        $result = $api->send($estate);
        if (
            $result['status']['code'] !== 200
            && $result['response']['results'][0]['status']['message'] == 'Entry could not be modified'
        ) {
            foreach ($params as $key => $value) {
                try {
                    $singleFieldEstate = [$key => $value];
                    $result = $api->send(
                        (new OnOffice\Requests\Edit\Estate($estateId))->setData($singleFieldEstate)
                    );
                    if ($result['status']['code'] !== 200) {
                        // log the error
                        $errors[$key] = $result['response']['results'][0]['status']['message'];
                    }
                } catch (Exception $e) {
                    // log the error
                    $errors[$key] = $e->getMessage();

                    continue;   // Skip to next field
                }
            }
        }

        if (! isset($result['response']['results'][0]['data']['records'])) {
            // throw exception
            throw new Exception(json_encode($result));
        }
        if (
            isset($result['response']['results'][0]['resourceid']) &&
            is_numeric($result['response']['results'][0]['resourceid'])
        ) {
            $id = (int) $result['response']['results'][0]['resourceid'];
        } else {
            $id = (int) $result['response']['results'][0]['data']['records'][0]['id'];
        }

        return [
            'id' => $id,
            'error' => $errors ?? [],
            'result' => $result,
        ];
    }

    public static function checkForSpecialCaseCreate($params)
    {
        return $params;
    }

    public static function removeUniqueFieldsFromParams($params, $uniqueFields)
    {
        foreach ($uniqueFields as $filterItem) {
            foreach ($params as $key => $param) {
                if (
                    $filterItem === $key
                ) {
                    unset($params[$key]);
                }
            }
        }

        return $params;
    }

    public function checkMultiselectFields($record, $onOfficeFieldsRaw, $recordId)
    {
        $params = [];

        foreach ($record as $fieldKey => $value) {
            $onOfficeField = collect($onOfficeFieldsRaw)->where('label_id', $fieldKey)->first();
            if ($onOfficeField['type'] === 'multiselect') {
                // get current params from address
                $params[$fieldKey] = $this->getApi()->send(
                    [
                        (new OnOffice\Requests\Read\Address())
                            ->setRecordIds([$recordId])
                            ->setParams([$fieldKey]),
                    ]
                );

                $params[$fieldKey] = ['response']['results'][0]['data']['records'][0]['elements'][$fieldKey] ?? '';

                if (isset($params[$fieldKey])) {
                    $params[$fieldKey] = array_filter(explode('|', $params[$fieldKey]));
                    $params[$fieldKey][] = $value;
                    $params[$fieldKey] = array_values(array_unique($params[$fieldKey]));
                }
            } else {
                $params[$fieldKey] = $value;
            }
        }

        return $params;
    }

    public static function getEstateFields(OnOffice\Api $api)
    {
        $request = (new OnOffice\Requests\Get\Fields());
        $request->setModules(['estate']);
        $request->setLabels(true);
        $request->setLanguage('DEU');
        $request->setRealDataTypes(true);
        $request->setShowFieldMeasureFormat(true);
        $request->setShowFieldFilters(true);
        $response = $api->send([$request]);
        $fields = [];
        foreach ($response['response']['results'][0]['data']['records'][0]['elements'] as $key => $field) {
            if ($key === 'label') {
                continue;
            }
            // add the key to the field
            $field['label_id'] = $key;
            $fields[] = $field;
        }

        return $fields;
    }

    public static function label(): string
    {
        return 'Estate';
    }

    private function getApi(): OnOffice\Api
    {
        return new OnOffice\Api(
            token: $this->connector['token'],
            secret: $this->connector['secret']
        );
    }

    public function getOnOfficeRegions(): array
    {
        $api = $this->getApi();

        $request = (new OnOffice\Requests\Get\Region());
        $response = $api->send([$request]);

        $regions = [];
        foreach ($response['response']['results'][0]['data']['records'] as $key => $field) {
            // add the key to the field
            $regions[] = array_merge(['id_internal' => $field['id']], $field['elements']);
        }

        return $regions;
    }
}
