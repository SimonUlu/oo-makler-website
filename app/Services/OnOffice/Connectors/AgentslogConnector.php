<?php

namespace App\Services\OnOffice\Connectors;

use App\Models\SyncLogError;
use App\Services\Connector\AbstractApiConnector;
use App\Services\OnOffice;

class AgentslogConnector extends AbstractApiConnector
{
    public function update($record, $params): array
    {
        // not available
        return [];
    }

    public function createRelation(array $parentId, array $childId, string $relationType): array
    {
        // not available
        return [];
    }

    public function updateOrCreate($records, $uniqueFields): array
    {
        // not available
        return [];
    }

    public function uploadFileTmp($records): ?string
    {
        // not available
        return null;
    }

    public function uploadFile($records, $resourceId): ?string
    {
        // not available
        return null;
    }

    public function create($records): array
    {
        $requests = [];
        foreach ($records as $record) {
            $agentslog = (new OnOffice\Requests\Create\Agentslog());
            $requests[] = $agentslog;
        }

        $response = $this->getApi()->send($requests);
        $index = 0;
        $ids = [];
        foreach ($records as $importId => $record) {
            $ids[$importId] = $response['response']['results'][$index]['data']['records'][0]['id'];
            $index++;
        }

        return $ids;
    }

    public function prepareFilterForOnOffice(string|array $values, $operator): array
    {
        return [
            'op' => $operator,
            'val' => $values,
        ];
    }

    public function getOnOfficeFields(): array
    {
        $api = $this->getApi();

        return self::getAgentslogFields($api);
    }

    public function getRecord(
        $filter = null,
        $resourceIdEstate = null,
        $resourceIdAddress = null,
        $offset = 0,
        $limit = 500,
        array $params = ['Nr'],
        $amountToFetch = null
    ): ?array {

        $totalFetched = 0;

        $request = (new OnOffice\Requests\Read\Agentslog($resourceIdEstate, $resourceIdAddress));

        if ($resourceIdEstate) {
            $request->setEstateId($resourceIdEstate);
        }

        if ($resourceIdAddress) {
            $request->setAddressId($resourceIdAddress);
        }

        if (! empty($filter)) {
            $request->setFilter($filter['field'], $filter['operator'], $filter['value']);
        }

        // check if full mail was requested
        if (in_array('mailbody', $params)) {
            $request->setReadFullMail(true);
            // unset field in request params
            unset($params[array_search('mailbody', $params)]);
        }

        $request->setSortBy('Datum_bearb', 'ASC');

        $request->setParams($params);

        // return $response['response']['results'][0]['data']['records'] ?? null;

        do {
            $request->setOffset($offset);
            // If an amount is specified and the remaining amount is less than the limit, use the remaining amount
            if (isset($amount) && ($amount - $totalFetched) < $limit) {
                $limit = $amount - $totalFetched;
            }

            $request->setLimit($limit);

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
        $resourceIdEstate = null,
        $resourceIdAddress = null,
        array $params = ['Nr'],
        $offset = 0,
        $limit = 500,
        $sortBy = ['Datum_bearb' => 'ASC']
    ): ?array {
        $request = (new OnOffice\Requests\Read\Agentslog($resourceIdEstate, $resourceIdAddress));

        if ($resourceIdEstate) {
            $request->setEstateId($resourceIdEstate);
        }

        if ($resourceIdAddress) {
            $request->setAddressId($resourceIdAddress);
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

    public static function getAgentslogFields(OnOffice\Api $api)
    {
        $request = (new OnOffice\Requests\Get\Fields());
        $request->setModules(['agentslog']);
        $request->setLabels(true);
        $request->setLanguage('DEU');
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
        return 'Agentslog';
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
