<?php

namespace App\Services\OnOfficeApiHandlerService;

use App\Exceptions\OnOfficeApiReadException;
use App\Services\OnOfficeApiService\Api;
use App\Services\OnOfficeApiService\OnOfficeQueryBuilderGet;
use App\Services\OnOfficeApiService\OnOfficeQueryBuilderModify;
use Illuminate\Support\Facades\Log;
use onOffice\SDK\onOfficeSDK;

class ModifyHandler
{
    public Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function address(int $resourceId, array $parameters): array
    {
        $queryBuilder = new OnOfficeQueryBuilderModify('address');

        $queryBuilder
            ->setResourceId($resourceId)
            ->setData(
                $parameters
            );

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'der Adresse');
    }

    public function handleSend(OnOfficeQueryBuilderModify $queryBuilder, string $module): array
    {
        $response = $this->api->send($queryBuilder);

        if (isset($response['error']) && ! empty($response['error'] && $response['status_code'] === true)) {
            $message = ' Fehler: '.$response['status']['message'];

            return [];
        }

        if (! empty($response['status']['errorcode'])) {
            $message = ' Fehler: '.$response['status']['message'];

            $message = ' Fehler: '.$response['response']['results'][0]['status']['message'];
            Log::error($response);
            throw new OnOfficeApiReadException($message);
        }

        return $response['response']['results'][0] ?? [];
    }

    // private static function checkForAddressSpecialCase($leadData, $apiData)
    // {
    //     if (isset($leadData['phone'])) {
    //         if ($leadData['phone'] !== substr($apiData['phone'], 3)) {
    //             $leadData['phone'] = [
    //                 'action' => 'add',
    //                 'newvalue' => $leadData['phone'],
    //             ];
    //         }
    //     }

    //     if (isset($leadData['Telefon1'])) {
    //         if ($leadData['Telefon1'] !== substr($apiData['Telefon1'], 3)) {
    //             $leadData['phone'] = [
    //                 'action' => 'add',
    //                 'newvalue' => $leadData['Telefon1'],
    //             ];
    //         }
    //     }
    //     if (isset($leadData['Telefon1'])) {
    //         unset($leadData['Telefon1']);
    //     }

    //     if (isset($leadData['Email']) && $leadData['Email'] != $apiData['Email']) {
    //         $leadData['email'] = [
    //             'action' => 'add',
    //             'newvalue' => $leadData['Email'],
    //         ];
    //         unset($leadData['Email']);
    //     } elseif (isset($leadData['Email'])) {
    //         unset($leadData['Email']);
    //     }

    //     return $leadData;
    // }

    // public function setRelationEstate($relation, $estateRecordId, $addressRecordId)
    // {
    //     switch ($relation) {
    //         case 'buyer':
    //             $relationType = onOfficeSDK::RELATION_TYPE_BUYER;
    //             break;
    //         case 'contactPerson':
    //             $relationType = onOfficeSDK::RELATION_TYPE_CONTACT_PERSON;
    //             break;
    //         case 'renter':
    //             $relationType = onOfficeSDK::RELATION_TYPE_TENANT;
    //             break;
    //         case 'owner':
    //             $relationType = onOfficeSDK::RELATION_TYPE_OWNER;
    //             break;
    //         case 'interested':
    //             //$relationType = onOfficeSDK::RELATION_TYPE_COMPLEX_ESTATE_UNITS;
    //             break;
    //         default:
    //     }

    //     $queryBuilder = new OnOfficeQueryBuilderGet('idsfromrelation');
    //     // build query to get all relation
    //     $queryBuilder
    //         ->setRelationType($relationType)
    //         ->setParentIds($estateRecordId)
    //         ->setChildIds($addressRecordId)
    //         ->render();

    //     return $this->handleSend($queryBuilder, 'der Estate Relation');
    // }

}
