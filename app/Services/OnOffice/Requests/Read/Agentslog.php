<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class Agentslog extends AbstractRequest
{
    /**
     * Estates constructor.
     */
    public function __construct(?int $estateId, ?int $addressId)
    {
        parent::__construct(self::ACTION_ID_READ, 'agentslog');

        if ($estateId) {
            $this->parameters['estateid'] = $estateId;
        }

        if ($addressId) {
            $this->parameters['addressid'] = $addressId;
        }

        $this->parameters['data'] = [
            'Objekt_nr',
            'Adress_nr',
            'Aktionsart',
            'Aktionstyp',
            'Datum',
            'created',
            'Benutzer',
            'Benutzer_nr',
            'Datum_bearb',
            'Kosten',
            'Bemerkung',
            'merkmal',
            'HerkunftKontakt',
            'dauer',
            'Beratungsebene',
            'Absagegrund',
        ];
    }

    public function setParams(array $params): Agentslog
    {
        $this->parameters['data'] = $params;

        return $this;
    }

    public function setLimit(int $limit): Agentslog
    {
        $this->parameters['listlimit'] = $limit;

        return $this;
    }

    public function setOffset(int $offset): Agentslog
    {
        $this->parameters['listoffset'] = $offset;

        return $this;
    }

    public function setEstateId(int $estateId): Agentslog
    {
        $this->parameters['estateid'] = $estateId;

        return $this;
    }

    public function setAddressId(int $addressId): Agentslog
    {
        $this->parameters['addressid'] = $addressId;

        return $this;
    }

    public function setSortBy(string $column, string $direction = 'ASC'): Agentslog
    {
        $this->parameters['sortby'][$column] = $direction;

        return $this;
    }

    public function setSortOrder(string $order = 'ASC'): Agentslog
    {
        $this->parameters['sortorder'] = $order;

        return $this;
    }

    public function setReadFullMail(bool $readFullMail): Agentslog
    {
        $this->parameters['fullmail'] = $readFullMail;

        return $this;
    }

    public function setFilter(string $column, array $filter): Agentslog
    {
        $this->parameters['filter'][$column] = $filter;

        return $this;
    }
}
