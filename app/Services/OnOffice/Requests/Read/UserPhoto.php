<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class UserPhoto extends AbstractRequest
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_READ, 'userphoto');
    }

    public function setParams(array $params): UserPhoto
    {
        $this->parameters = $params;

        return $this;
    }

    public function setResourceId($resourceId): static
    {
        parent::setResourceId($resourceId);

        return $this;
    }
}
