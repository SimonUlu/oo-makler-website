<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class EstateSeller extends AbstractRequest
{
    /**
     * Estates constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_GET, 'idsfromrelation');

        $this->parameters['relationtype'] = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:owner';
    }

    /**
     * @param  string[]  $parentIds
     */
    public function setParentIds(array $parentIds): EstateSeller
    {
        $this->parameters['parentids'] = $parentIds;

        return $this;
    }
}
