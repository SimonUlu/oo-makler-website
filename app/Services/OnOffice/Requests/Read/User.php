<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class User extends AbstractRequest
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_READ, 'user', [
            'data' => [
                'Anrede',
                'Titel',
                'Vorname',
                'Nachname',
                'Firma',
                'PLZ',
                'Ort',
                'Strasse',
                'Hausnummer',
                'Land',
                'Mobil',
                'Telefon',
                'email',
            ],
        ]);
    }

    public function setParams(array $params): User
    {
        $this->parameters['data'] = $params;

        return $this;
    }

    public function filterIds(array $ids): User
    {
        $this->parameters['filter']['Nr'][] = [
            'op' => 'in',
            'val' => $ids,
        ];

        return $this;
    }

    public function setFilter(string $column, array $filter): User
    {
        $this->parameters['filter'][$column] = $filter;

        return $this;
    }

    public function setLimit(int $limit): User
    {
        $this->parameters['listlimit'] = $limit;

        return $this;
    }

    public function setSortBy(string $column, string $direction = 'ASC'): User
    {
        $this->parameters['sortby'] = [
            $column => $direction,
        ];

        return $this;
    }

    public function setResourceId($resourceId): static
    {
        $this->parameters['resourceid'] = $resourceId;

        return $this;
    }
}
