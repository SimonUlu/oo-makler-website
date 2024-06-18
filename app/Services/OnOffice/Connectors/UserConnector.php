<?php

namespace App\Services\OnOffice\Connectors;

use App\Services\Connector\AbstractApiConnector;
use App\Services\OnOffice;
use Illuminate\Support\Str;

class UserConnector extends AbstractApiConnector
{
    public function create($records): array
    {
        return [];
    }

    public function createRelation(array $parentId, array $childId, string $relationType): array
    {
        return [];
    }

    public function prepareFilterForOnOffice(array $values, $operator): array
    {
        return [
            'op' => $operator,
            'val' => $values,
        ];
    }

    public function uploadFileTmp($record): ?string
    {
        return null;
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

    public function checkIfUserExists($record, $uniqueFields)
    {

        if (empty($uniqueFields)) {
            return null;
        }

        // check if dublicateCheckAttributes are all in the keys of record
        $uniqueFieldscheck = collect($uniqueFields)->filter(function ($value) use ($record) {
            return self::multiArrayKeyExists($value, $record);
        })->values()->toArray();

        if (count($uniqueFieldscheck) !== count($uniqueFields)) {
            return null;
        }

        $user = (new OnOffice\Requests\Read\User());
        $result = $this->getApi()->send([$user]);

        if ($result['response']['results'][0]['status']['errorcode'] != 0) {
            throw new \Exception(json_encode($result));
        }

        return $result['response']['results'][0]['data']['records'][0] ?? null;
    }

    public function getOnOfficeFields(): array
    {
        $api = $this->getApi();

        return self::getUserFields($api);
    }

    public function getRecord(
        $filter = null,
        $resourceId = null,
        array $params = ['id'],
        $offset = 0,
        $limit = 500,
        $sortBy = null
    ): ?array {
        $request = (new OnOffice\Requests\Read\User());
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
        $filter = null,
        $resourceId = null,
        array $params = ['id'],
        $offset = 0,
        $limit = 500,
        $sortBy = null
    ): ?array {
        $request = (new OnOffice\Requests\Read\User());
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

        $request->setLimit($limit);
        $request->setParams($params);
        if (isset($sortBy)) {
            $request->setSortBy(array_key_first($sortBy), $sortBy[array_key_first($sortBy)]);
        }
        $response = $this->getApi()->send([$request]);
        $records = $response['response']['results'][0]['data']['records'];

        return $records ?? [];
    }

    public function updateOrCreate($records, $uniqueFields, $doNotUpdate = null): array
    {
        return [];
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

    public function checkForSpecialCaseModify($params, $userData)
    {
        $phoneExists = false;

        // check if params has phone or Telefon1
        if (! in_array('phone', $params) && ! in_array('Telefon1', $params)) {
            return $params;
        }

        foreach (['phone', 'Telefon1'] as $tel) {
            if (isset($params[$tel])) {
                $lastThreeDigitsOfPhone = substr($params[$tel], -3);  // Get the last 3 digits of $phone

                $phoneValues = collect($userData)->filter(function ($value, $key) {
                    return Str::contains($key, 'phone');
                })->values();

                $phoneExists = $phoneValues->contains(function ($value) use ($lastThreeDigitsOfPhone) {
                    return Str::endsWith($value, $lastThreeDigitsOfPhone);
                });
            }
        }

        if (! $phoneExists) {
            $params['phone'] = [
                'action' => 'add',
                'newvalue' => $params['Telefon1'],
            ];
        }

        unset($params['Telefon1']);

        if (isset($params['Email']) && $params['Email'] != $userData['Email']) {
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

    public function checkMultiselectFields($record, $onOfficeFieldsRaw, $recordId)
    {
        $params = [];
        foreach ($record as $value) {
            $fieldKey = array_key_first($value);
            $onOfficeField = collect($onOfficeFieldsRaw)->where('label_id', $fieldKey)->first();
            if ($onOfficeField['type'] === 'multiselect') {
                // get current params from user
                $params[$fieldKey] = $this->getApi()->send(
                    [
                        (new OnOffice\Requests\Read\User())
                            ->setRecordIds([$recordId])
                            ->setParams([$fieldKey]),
                    ]
                );

                $params[$fieldKey] = ['response']['results'][0]['data']['records'][0]['elements'][$fieldKey] ?? '';

                if (isset($params[$fieldKey])) {
                    $params[$fieldKey] = array_filter(explode('|', $params[$fieldKey]));
                    $params[$fieldKey][] = $value[$fieldKey];
                    $params[$fieldKey] = array_values(array_unique($params[$fieldKey]));
                }
            } else {
                $params[$fieldKey] = $value[$fieldKey];
            }
        }

        return $params;
    }

    public function update($records, $params): array
    {
        $requests = [];
        foreach ($records as $id => $record) {
            $user = (new OnOffice\Requests\Edit\User($id));
            if (isset($data['Vorname'])) {
                $user->setVorname($data['Vorname']);
            }
            if (isset($data['Name'])) {
                $user->setName($data['Name']);
            }
            if (isset($record['Plz'])) {
                $user->setPlz($record['Plz']);
            }
            $requests[] = $user;
        }

        $result = $this->getApi()->send($requests);

        return $result['response']['results'][0]['data']['records'][0]['id'] ?? [];
    }

    public static function getUserFields(OnOffice\Api $api)
    {
        $request = (new OnOffice\Requests\Get\Fields());
        $request->setModules(['user']);
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
        return 'User';
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
