<?php

namespace App\Services\OnOfficeApiHelpers;

use App\Services\OnOfficeService;

class AgentslogHelper extends OnOfficeService
{
    public function __construct()
    {
        // get api connection from parent constructor
        parent::__construct();
    }

    public function createAgentslogEntry(array $addressIds, ?int $estateId, string $actionKind, string $actionType, string $note): array
    {
        $response = $this->create()->createActivity(
            addressIds: $addressIds,
            estateId: $estateId,
            actionKind: $actionKind,
            actionType: $actionType,
            note: $note,
        );

        if (isset($response[0])) {
            $response = $response[0]['data']['records'];
        } else {
            $response = $response['data']['records'];
        }

        // TODO: implement onOffice Exception Handling
        if (! empty($response['status']['errorcode']) && $response['status']['errorcode'] !== 0) {
            // return error message
            return $response['status']['message'];
        }

        return $response;
    }
}
