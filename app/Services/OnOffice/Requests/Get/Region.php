<?php

namespace App\Services\OnOffice\Requests\Get;

use App\Services\OnOffice\Requests\AbstractRequest;

class Region extends AbstractRequest
{
    /**
     * File constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_GET, 'regions', [
            'language' => 'DEU',
        ]);
    }
}
