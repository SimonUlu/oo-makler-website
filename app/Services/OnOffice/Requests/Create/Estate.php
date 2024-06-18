<?php

namespace App\Services\OnOffice\Requests\Create;

use App\Services\OnOffice\Requests\AbstractRequest;

class Estate extends AbstractRequest
{
    //     const COLUMN_SENDERSOFTWARE = 'ind_2340_Feld_ObjTech25'; // for test tenant
    const COLUMN_SENDERSOFTWARE = 'ind_2334_Feld_ObjTech24';

    public function __construct()
    {
        parent::__construct(self::ACTION_ID_CREATE, 'estate');
    }

    public function setData(array $data): Estate
    {
        $this->parameters = [
            'data' => $data,
        ];

        return $this;
    }
}
