<?php

namespace App\Services\OnOffice\Connectors;

use App\Models\SyncLogError;
use App\Services\Connector\AbstractApiConnector;
use App\Services\OnOffice;

class CalendarConnector extends AbstractApiConnector
{
    public function create($records): array
    {
        return [];
    }

    public function createRelation(array $parentId, array $childId, string $relationType): array
    {
        return [];
    }

    public function update($recordId, $params): array
    {
        return [];
    }

    public function updateOrCreate($records, $uniqueFields, $doNotUpdate = null): array
    {
        return [];
    }

    public function getOnOfficeFields(): array
    {
        $api = $this->getApi();

        return self::getCalendarFields($api);
    }

    public static function getCalendarFields(OnOffice\Api $api)
    {
        $request = (new OnOffice\Requests\Get\Fields());
        $request->setModules(['calendar']);
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

    public function getRecordChunk(
        $apiConnectionId = null,
        $filters = null,
        $resourceId = null,
        $sortBy = ['start_dt' => 'ASC']
    ): ?array {
        if ($resourceId) {
            $request = (new OnOffice\Requests\Read\Calendar($resourceId));
        } else {
            $request = (new OnOffice\Requests\Read\Calendar());
        }

        if (! empty($filters)) {
            if (isset($filters['modifiedstart']) && isset($filters['modifiedend'])) {
                $request->setModifiedStart($filters['modifiedstart']);
                $request->setModifiedEnd($filters['modifiedend']);
            } else {
                // fill error into sync_log_errors
                $error = new SyncLogError();
                $error->api_connection_id = $apiConnectionId;
                $error->module = 'calendar';
                $error->error = 'Read';
                $error->error_code = 400;
                $error->error_message = 'Filters modifiedstart and modifiedend are required';
                $error->error_data = ['request' => $request];
                $error->save();

                throw new \Exception('Filters modifiedstart and modifiedend are required');
            }
        }

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
            $error->module = 'calendar';
            $error->error = 'Read';
            $error->error_code = $response['response']['results'][0]['status']['errorcode'];
            $error->error_message = $response['response']['results'][0]['status']['message'];
            $error->error_data = ['request' => $request, 'respone' => $response];
            $error->save();
        }

        $records = $response['response']['results'][0];

        return $records ?? [];
    }

    public function prepareFilterForOnOffice(string|array $values, $operator): array
    {
        return [
            'op' => $operator,
            'val' => $values,
        ];
    }

    public function getRecord(
        $filter = null,
        $resourceId = null,
        array $params = ['objektnr_extern'],
        $offset = 0,
        $limit = 500,
        $sortBy = null
    ): ?array {
        return [];
    }

    public function uploadFileTmp($record): ?string
    {
        return null;
    }

    public function uploadFile($imageParams, $resourceId): ?string
    {
        return null;
    }

    public static function label(): string
    {
        return 'Calendar';
    }

    private function getApi(): OnOffice\Api
    {

        return new OnOffice\Api(
            token: $this->connector->token,
            secret: $this->connector->secret
        );
    }
}
