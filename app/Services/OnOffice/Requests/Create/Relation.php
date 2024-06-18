<?php

namespace App\Services\OnOffice\Requests\Create;

use App\Services\OnOffice\Requests\AbstractRequest;

class Relation extends AbstractRequest
{
    public function __construct(
        string $relationType,
        array $parentIds,
        array $childIds,
    ) {
        parent::__construct(self::ACTION_ID_CREATE, 'relation');

        $this->parameters = [
            'relationtype' => $relationType,
            'parentid' => $parentIds,
            'childid' => $childIds,
        ];
    }
}
