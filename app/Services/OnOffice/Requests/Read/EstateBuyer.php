<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class EstateBuyer extends AbstractRequest
{
    /**
     * Estates constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_GET, 'idsfromrelation');

        $this->parameters['relationtype'] = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:buyer';
    }

    /**
     * @param  string[]  $parentIds
     */
    public function setParentIds(array $parentIds): EstateBuyer
    {
        $this->parameters['parentids'] = $parentIds;

        return $this;
    }
}
