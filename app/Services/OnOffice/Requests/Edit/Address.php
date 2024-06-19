<?php

namespace App\Services\OnOffice\Requests\Edit;

class Address extends \App\Services\OnOffice\Requests\Create\Address
{
    public function __construct(string $resourceId)
    {
        parent::__construct(self::ACTION_ID_MODIFY);
        $this->setResourceId($resourceId);
    }
}
