<?php

namespace App\Services\OnOfficeApiHelpers;

use App\Services\OnOfficeService;

class UpdateOrCreateAddressHelper extends OnOfficeService
{
    public function __construct()
    {
        // get api connection from parent constructor
        parent::__construct();
    }

    public function updateOrCreate(array $parameters, ?array $filter = null, ?int $limit = null)
    {
        // Make API call to read an address using the email as a filter
        $response = $this->read()->address(array_keys($parameters), $filter, $limit);

        if (isset($response[0])) {
            $response = $response[0];
        }

        // TODO: implement onOffice Exception Handling
        if ($response['status']['errorcode'] !== 0) {
            // return error message
            return $response['status']['message'];
        }

        if (count($response['data']['records']) > 0) {
            // The user exists, update the address
            // if there is more than one entry, we only update the first one
            return $response;
        } else {
            // The user does not exist, create a new address
            return $this->create()->address(array_merge($parameters, ['HerkunftKontakt' => 'webseite_system']));
        }
    }

    public function updateOrCreateNewsletter(array $parameters, ?array $filter = null, ?int $limit = null)
    {
        // Make API call to read an address using the email as a filter
        $response = $this->read()->address(array_keys($parameters), $filter, $limit);

        if ($response['status']['errorcode'] !== 0) {
            // return error message
            return $response['status']['message'];
        }

        if (count($response['data']['records']) > 0) {
            // The user exists, update the address
            // if there is more than one entry, we only update the first one
            // newsletter_aktiv = 3 means that the user has double-opt-in left
            // 1|0|2|3|4 => Ja|Nein|Absage|Double Opt-In ausstehend|keine Angabe
            $result = $this->modify()->address($response['data']['records'][0]['id'], ['newsletter_aktiv' => '3']);
        } else {
            // The user does not exist, create a new address
            $result = $this->create()->address(array_merge($parameters, ['newsletter_aktiv' => '3'], ['HerkunftKontakt' => 'webseite_system']));
        }

        if (isset($result['data']['records'][0]['elements']['success'])) {
            // return json success message
            return $result;
        } elseif (isset($result['data']['records'][0]['elements']['success'])) {
            return $result;
            // return error message
        } elseif (isset($result['status']['message'])) {
            return $result;
        } elseif (isset($result[0]['status']['message'])) {
            return $result[0];
        } else {
            return 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.';
        }
    }
}
