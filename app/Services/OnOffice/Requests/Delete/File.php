<?php

namespace App\Services\OnOffice\Requests\Delete;

use App\Services\OnOffice\Requests\AbstractRequest;

class File extends AbstractRequest
{
    public function __construct(int $fileId, int $parentId, string $relationType = 'estate')
    {
        parent::__construct(self::ACTION_ID_DELETE, 'fileRelation');

        $this->parameters['fileId'] = $fileId;
        $this->parameters['parentid'] = $parentId;
        $this->parameters['relationtype'] = $relationType;
    }
}
