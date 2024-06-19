<?php

namespace App\Services\OnOffice\Requests\Edit;

use App\Services\OnOffice\Enums\EstateStatus;
use App\Services\OnOffice\Requests\AbstractRequest;

class Estate extends AbstractRequest
{
    public function __construct(string $resourceId)
    {
        parent::__construct(self::ACTION_ID_MODIFY, 'estate', [], $resourceId);
    }

    public function setData(array $data): Estate
    {
        $this->parameters = [
            'data' => $data,
        ];

        return $this;
    }

    public function setStatus(EstateStatus $status): Estate
    {
        $this->parameters['data']['status'] = $status->value;

        return $this;
    }

    public function setAdditionalHeader(string $value): Estate
    {
        $this->parameters['data']['additionalHeader'] = $value;

        return $this;
    }
}
