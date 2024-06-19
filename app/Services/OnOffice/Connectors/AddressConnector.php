<?php

namespace App\Services\OnOffice\Connectors;

use App\Models\SyncLogError;
use App\Services\Connector\AbstractApiConnector;
use App\Services\OnOffice;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AddressConnector extends AbstractApiConnector
{
    public function search($apiConnectionId, $input, $searchCaseSensitive = false): array
    {
        $request = (new OnOffice\Requests\Search\Address());

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
        $address = (new OnOffice\Requests\Create\Address());
        $address->setParams($params);
        $response = $this->getApi()->send($address);

        return $response ?? [];
    }

    public function prepareFilterForOnOffice(string|array $values, $operator): array
    {
        return [
            'op' => $operator,
            'val' => $values,
        ];
    }

    /**
     * @throws Exception
     */
    public function createRelation(array $parentId, array $childId, string $relationType): array
    {
        $address = (new OnOffice\Requests\Edit\Address($childId[0]));
        $address->setParams(['Tipp_ID' => $parentId[0]]);

        $response = $this->getApi()->send($address);
        if ($response['response']['results'][0]['status']['errorcode'] != 0) {
            throw new Exception(json_encode($response));
        }

        return $response;
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

        return $response['response']['results'][0]['data']['records'][0]['elements']['tmpUploadId'];
    }

    public function multiArrayKeyExists($key, $array): bool
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

    public function checkIfAddressExists($record, $uniqueFields)
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

        $address = (new OnOffice\Requests\Read\Address());
        foreach (array_keys($uniqueFields) as $filterItem) {
            collect($record)->filter(function ($value, $key) use ($filterItem, $address) {
                //get first dimension of array
                if (
                    $filterItem === $key
                ) {
                    // if key is Email, make it lowercase
                    if ($key === 'Email') {
                        $value = strtolower($value);
                    }
                    $address->setFilter($key, [self::prepareFilterForOnOffice([$value], 'IN')]);
                }
            });
        }

        $result = $this->getApi()->send([$address]);

        if ($result['response']['results'][0]['status']['errorcode'] != 0) {
            throw new \Exception(json_encode($result));
        }

        return $result['response']['results'][0]['data']['records'][0] ?? null;
    }

    public function getOnOfficeFields(): array
    {
        $api = $this->getApi();

        return self::getAddressFields($api);
    }

    public function getRecord(
        $filter = null,
        $resourceId = null,
        array $params = ['KdNr'],
        $offset = 0,
        $limit = 500,
        $sortBy = null
    ): ?array {
        $request = (new OnOffice\Requests\Read\Address());
        if ($resourceId) {
            $request->setResourceId($resourceId);
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
            $request->setParams($params);
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
        $apiConnectionId = null,
        $filters = null,
        $resourceId = null,
        array $params = ['KdNr'],
        $offset = 0,
        $limit = 500,
        $sortBy = ['Aenderung' => 'ASC']
    ): ?array {

        $request = (new OnOffice\Requests\Read\Address());
        if ($resourceId) {
            $request->setResourceId($resourceId);
        }

        if (! empty($filters)) {
            foreach ($filters as $filter) {
                $request->setFilter(
                    $filter['field'],
                    [self::prepareFilterForOnOffice(
                        $filter['value'],
                        $filter['operator'] ?? 'IN'
                    )]
                );
            }
        }

        // if params has outlookSync or veroeffentlichen, remove it
        $notAllowedParams = ['outlookSync'];
        foreach ($notAllowedParams as $index) {
            if (in_array($index, $params)) {
                unset($params[array_search($index, $params)]);
            }
        }

        $request->setOffset($offset);
        $request->setLimit($limit);
        $request->setParams($params);

        if (isset($sortBy)) {
            $request->setSortBy(array_key_first($sortBy));
            $request->setSortOrder($sortBy[array_key_first($sortBy)]);
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

    public function updateOrCreate($record, $uniqueFields, $doNotUpdate = null): array
    {
        $api = $this->getApi();
        $onOfficeFieldsRaw = self::getAddressFields($api);

        // check if address exists in onOffice
        $addressData = self::checkIfAddressExists($record, $uniqueFields);
        $addressId = $addressData['id'] ?? null;

        if ($addressId) {
            $address = (new OnOffice\Requests\Edit\Address($addressId));
            // prepare the params for the request
            $params = self::checkMultiselectFields($record, $onOfficeFieldsRaw, $addressId);
            $params = self::removeUniqueFieldsFromParams($params, $uniqueFields, $onOfficeFieldsRaw);
            $params = self::checkForSpecialCaseModify($params, array_filter($addressData['elements']));
        } else {
            $address = (new OnOffice\Requests\Create\Address());

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

        $address->setParams($params);
        $result = $api->send($address);
        if (
            $result['status']['code'] !== 200
            && $result['response']['results'][0]['status']['message'] == 'Entry could not be modified'
        ) {
            foreach ($params as $key => $value) {
                try {
                    $singleFieldAddress = [$key => $value];
                    $result = $api->send(
                        (new OnOffice\Requests\Edit\Address($addressId))->setParams($singleFieldAddress)
                    );
                    if ($result['status']['code'] !== 200) {
                        // log the error
                        $errors[$key] = $result['response']['results'][0]['status']['message'];
                    }
                } catch (\Exception $e) {
                    // log the error
                    $errors[$key] = $e->getMessage();

                    continue;   // Skip to next field
                }
            }
        }

        if (! isset($result['response']['results'][0]['data']['records'])) {
            // throw exception
            throw new \Exception(json_encode($result));
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

        return $response['response']['results'][0]['data']['records'][0]['elements']['fileId'] ?? -1;
    }

    public function checkForSpecialCaseModify($params, $addressData)
    {
        $phoneExists = false;

        foreach (['phone', 'Telefon1'] as $tel) {
            if (isset($params[$tel])) {
                $lastThreeDigitsOfPhone = substr($params[$tel], -4);  // Get the last 4 digits of $phone

                $phoneValues = collect($addressData)->filter(function ($value, $key) {
                    return Str::contains($key, 'phone');
                })->values();

                $phoneExists = $phoneValues->contains(function ($value) use ($lastThreeDigitsOfPhone) {
                    return Str::endsWith($value, $lastThreeDigitsOfPhone);
                });
            }
        }

        if (! $phoneExists && (isset($params['Telefon1']) || isset($params['phone']))) {
            $params['phone'] = [
                'action' => 'add',
                'newvalue' => $params['Telefon1'],
            ];
        }

        unset($params['Telefon1']);
        unset($params['phone']);

        if (isset($params['Email']) && isset($addressData['Email']) && $params['Email'] != $addressData['Email']) {
            $params['email'] = [
                'action' => 'add',
                'newvalue' => $params['Email'],
            ];
            unset($params['Email']);
        } elseif (isset($params['Email'])) {
            unset($params['Email']);
        }

        return $params;
    }

    public function checkForSpecialCaseCreate($params)
    {
        if (isset($params['Telefon1'])) {
            $params['phone'] = $params['Telefon1'];
            unset($params['Telefon1']);
        }

        return $params;
    }

    public function removeUniqueFieldsFromParams($params, $uniqueFields, $onOfficeFieldsRaw)
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

    public function checkMultiselectFields($record, $onOfficeFieldsRaw, $recordId): array
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

    public function update($recordId, $params): array
    {
        $address = (new OnOffice\Requests\Edit\Address($recordId));
        $address->setParams($params);

        return $this->getApi()->send([$address]);
    }

    public static function getAddressFields(OnOffice\Api $api): array
    {
        $request = (new OnOffice\Requests\Get\Fields());
        $request->setModules(['address']);
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
        return 'Address';
    }

    private function getApi(): OnOffice\Api
    {
        $config = $this->connector;

        return new OnOffice\Api(
            token: $config->token,
            secret: $config->secret
        );
    }
}
