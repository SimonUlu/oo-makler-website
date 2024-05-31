<?php

namespace App\Services\OnOfficeApiHandlerService;

use App\Exceptions\OnOfficeApiReadException;
use App\Services\OnOfficeApiService\Api;
use App\Services\OnOfficeApiService\OnOfficeQueryBuilderRead;
use Illuminate\Support\Facades\Log;

class ReadHandler
{
    public Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function get(array $data, string $module, array $filters = [], ?int $resourceId = null, int $offset = 0, int $limit = 500, $getCntAbsolute = false): array
    {

        $entries = [];

        do {

            $queryBuilder = new OnOfficeQueryBuilderRead($module, $offset, $limit);

            $queryBuilder
                ->setData(
                    $data
                );

            if (! empty($filters)) {
                $failed = false;
                foreach ($filters as $key => $value) {
                    if ($failed) {
                        continue;
                    }
                    $failed = ! $this->validateFilter([$key => $value]);
                }

                if (! $failed) {
                    $queryBuilder->setFilter($filters);
                } else {
                    $queryBuilder = self::buildFilter($queryBuilder, $filters);
                }
            }

            if ($resourceId !== null) {
                $queryBuilder->setResourceId($resourceId);
            }

            $queryBuilder
                ->render();

            $result = $this->handleSend($queryBuilder, 'des Objekts');

            if (isset($entries['data']['records'])) {
                $entries['data']['records'] = array_merge($entries['data']['records'], $result['data']['records']);
            } else {
                $entries = $result;
            }

            $countEntries = count($result['data']['records']);

            // increase offset
            $offset += $limit;

        } while ($limit >= 500 && $countEntries == $limit && ! $getCntAbsolute);

        return $entries;

    }

    public function validateFilter($filter)
    {
        if (! is_array($filter)) {
            return false;
        }
        if (! isset($filter[array_key_first($filter)])) {
            return false;
        }
        if (! is_array($filter[array_key_first($filter)])) {
            return false;
        }
        if (! isset($filter[array_key_first($filter)][0]['op'])) {
            return false;
        }
        if (! isset($filter[array_key_first($filter)][0]['val'])) {
            return false;
        }
        // if filter val is strin true or false, fail
        if (is_string($filter[array_key_first($filter)][0]['val']) && ($filter[array_key_first($filter)][0]['val'] === 'true' || $filter[array_key_first($filter)][0]['val'] === 'false')) {
            return false;
        }

        return true;
    }

    public function buildFilter(OnOfficeQueryBuilderRead $queryBuilder, array $filters)
    {

        $filter = [];

        // check if filters has sort as key
        if (array_key_exists('sort', $filters)) {
            $queryBuilder->setSortBy($filters['sort']);
            unset($filters['sort']);
        }

        // check if filters has sortorder as key
        if (array_key_exists('sortorder', $filters)) {
            $queryBuilder->setSortOrder($filters['sortorder']);
            unset($filters['sortorder']);
        } else {
            $queryBuilder->setSortOrder('ASC');
        }

        // check if filters has limit as key
        if (array_key_exists('limit', $filters)) {
            $queryBuilder->setListLimit($filters['limit']);
            unset($filters['limit']);
        }

        // check if filters has page as key
        if (array_key_exists('page', $filters)) {
            $queryBuilder->setListOffset($filters['page']);
            unset($filters['page']);
        }

        foreach ($filters as $key => $value) {

            if (isset($value[0]['val'])) {
                if (! is_array($value[0]['val'])) {
                    if ($value[0]['val'] == 1 || $value[0]['val'] == 'true') {
                        $filter[strtolower($key)] = [
                            0 => [
                                'op' => '=',
                                'val' => 1,
                            ],
                        ];
                    }
                    if ($value[0]['val'] == 0 || $value[0]['val'] == 'false') {
                        $filter[strtolower($key)] = [
                            0 => [
                                'op' => '=',
                                'val' => 0,
                            ],
                        ];
                    }
                }
                if (is_array($value[0]['val'])) {
                    // skip for "Alle Orte"
                    $filter[strtolower($key)] = [
                        0 => [
                            'op' => 'IN',
                            'val' => array_keys($value[0]['val']),
                        ],
                    ];
                }
            } else {
                if (! is_array($value)) {
                    $filter[strtolower($key)] = [
                        0 => [
                            'op' => 'IN',
                            'val' => [$value],
                        ],
                    ];
                }
                if (is_array($value)) {
                    // skip for "Alle Orte"
                    $filter[strtolower($key)] = [
                        0 => [
                            'op' => 'IN',
                            'val' => array_keys($value),
                        ],
                    ];
                }
            }
        }

        $queryBuilder->setFilter(
            $filter
        );

        return $queryBuilder;
    }

    public function address(array $data, ?array $filter = null, ?int $limit = null): array
    {
        $queryBuilder = new OnOfficeQueryBuilderRead('address');

        $queryBuilder
            ->setData(
                $data
            );

        if ($filter !== null) {
            $queryBuilder->setFilter(
                $filter
            );
        }

        if ($limit !== null) {
            $queryBuilder->setListLimit($limit);
        }
        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Objekts');
    }

    public function userById(array $data, int $resourceId): array
    {
        $queryBuilder = new OnOfficeQueryBuilderRead('user');
        $queryBuilder
            ->setResourceId($resourceId)
            ->setResourceType('user')
            ->setData(
                $data
            );

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Users');
    }

    public function userPhoto(array $filter, ?int $limit = null): array
    {
        $queryBuilder = new OnOfficeQueryBuilderRead('address');
        $queryBuilder
            ->setResourceType('userphoto');

        if ($filter !== null) {
            $queryBuilder->setFilter(
                $filter
            );
        }

        if ($limit !== null) {
            $queryBuilder->setListLimit($limit);
        }
        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Objekts');
    }

    public function estate(array $estateFields, ?array $filter = null, ?int $maxNumber = null): array
    {
        $queryBuilder = new OnOfficeQueryBuilderRead('estate');
        // array_push($estateFields, 'Id');

        $queryBuilder
            ->setResourceType('estate')
            ->setData(
                $estateFields
            );

        if ($filter !== null) {
            $queryBuilder->setFilter(
                $filter
            );
        }
        if ($maxNumber !== null) {
            $queryBuilder
                ->setListLimit($maxNumber);
        }
        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Objekts');
    }

    public function readCustomerByKdNr(int $kdnr, array $addressFields): array
    {
        $queryBuilder = new OnOfficeQueryBuilderRead('address');

        $queryBuilder
            ->setData(
                $addressFields
            )
            ->setFilter(
                [
                    'KdNr' => [
                        ['op' => '=', 'val' => $kdnr],
                    ],
                ]
            );

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Objekts');
    }

    public function readAgentslog(string $actionKind, string $actionType, array $filter)
    {
        $queryBuilder = new OnOfficeQueryBuilderRead('agentslog');

        $queryBuilder
            ->setActionKind($actionKind)
            ->setActionType($actionType)
            ->setFilter($filter)
            ->setData(['Bemerkung']);

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Agentslogs');
    }

    /**
     * returns all user with id and name
     */
    public function handleSend(OnOfficeQueryBuilderRead $queryBuilder, string $module): array
    {
        $response = $this->api->send($queryBuilder);

        if (isset($response['error']) && ! empty($response['error'] && $response['status_code'] === true)) {
            $message = ' Fehler: '.$response['status']['message'];

            return [];
        }

        if (! empty($response['status']['errorcode'])) {
            $message = ' Fehler: '.$response['status']['message'];

            //TODO merken ob addresse vorher erstellt wurde
            $message = ' Fehler: '.$response['response']['results'][0]['status']['message'];
            Log::error($response);
            throw new OnOfficeApiReadException($message);
        }

        return $response['response']['results'][0] ?? [];
    }
}
