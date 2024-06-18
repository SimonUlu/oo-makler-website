<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class CheckUserRecordsRight extends AbstractRequest
{
    /**
     * Estates constructor.
     */
    public function __construct(
        int $userId,
        array $recordIds,
        string $action = 'read',
        string $module = 'estate',
    ) {
        parent::__construct(self::ACTION_ID_GET, 'checkuserrecordsright');
        $this->parameters = [
            'action' => $action,
            'module' => $module,
            'userId' => $userId,
            'recordIds' => $recordIds,
        ];
    }
}
