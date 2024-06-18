<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class Address extends AbstractRequest
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_READ, 'address', [
            'data' => [
                'KdNr',
            ],
        ]);
    }

    public function setParams(array $params): Address
    {
        $this->parameters['data'] = $params;

        return $this;
    }

    public function setSortBy(string $column): Address
    {
        $this->parameters['sortby'] = $column;

        return $this;
    }

    public function setSortOrder(string $order = 'ASC'): Address
    {
        $this->parameters['sortorder'] = $order;

        return $this;
    }

    public function setLimit(int $limit): Address
    {
        $this->parameters['listlimit'] = $limit;

        return $this;
    }

    public function setOffset(int $offset): Address
    {
        $this->parameters['listoffset'] = $offset;

        return $this;
    }

    public function setFilter(string $column, array $filter): Address
    {
        $this->parameters['filter'][$column] = $filter;

        return $this;
    }

    public function setRecordIds(array $recordIds): Address
    {
        $this->parameters['recordids'] = $recordIds;

        return $this;
    }

    public function setResourceId($resourceId): Address
    {
        // Call the parent's setResourceId method
        parent::setResourceId($resourceId);

        return $this;
    }
}
