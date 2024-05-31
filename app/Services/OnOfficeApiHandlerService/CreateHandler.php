<?php

namespace App\Services\OnOfficeApiHandlerService;

use App\Exceptions\OnOfficeApiCreateException;
use App\Services\OnOfficeApiService\Api;
use App\Services\OnOfficeApiService\OnOfficeQueryBuilderCreate;

class CreateHandler
{
    // TODO: define constants
    const RELATION_TYPE_BUYER = 'buyer';

    const RELATION_TYPE_CONTACT_PERSON = 'contactPerson';

    const RELATION_TYPE_TENANT = 'renter';

    const RELATION_TYPE_OWNER = 'owner';

    const RELATION_TYPE_COMPLEX_ESTATE_UNITS = 'interested';

    public Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function address(array $data): array
    {
        if (isset($data['Telefon1'])) {
            $data['phone'] = $data['Telefon1'];
            unset($data['Telefon1']);
        }

        $queryBuilderCreate = new OnOfficeQueryBuilderCreate('address');

        $queryBuilderCreate
            ->setData($data);

        $queryBuilderCreate
            ->render();

        return $this->handleSend($queryBuilderCreate, 'address')[0];
    }

    public function createEstate(array $data): array
    {
        $queryBuilderCreate = new OnOfficeQueryBuilderCreate('estate');

        $queryBuilderCreate
            ->setData($data);

        $queryBuilderCreate
            ->render();

        return $this->handleSend($queryBuilderCreate, 'estate');
    }

    public function searchCriteria(array $data, int $addressId): array
    {
        $queryBuilderCreate = new OnOfficeQueryBuilderCreate('searchcriteria');

        $queryBuilderCreate
            ->setAddressId($addressId)
            ->setData($data);

        $queryBuilderCreate
            ->render();

        return $this->handleSend($queryBuilderCreate, 'searchcriteria');
    }

    public function createTask(?int $addressId, ?int $estateId, $onOfficeTask)
    {
        $data =
            [
                'Art' => $onOfficeTask->kind,
                'Betreff' => $onOfficeTask->subject,
                'Verantwortung' => $onOfficeTask->responsiblity,
                'Bearbeiter' => $onOfficeTask->processor,
                'Aufgabe' => $onOfficeTask->task,
            ];

        $queryBuilder = new OnOfficeQueryBuilderCreate('task');
        $queryBuilder
            ->setData(
                $data
            );
        if ($addressId !== null) {
            $queryBuilder->setRelatedAddressId($addressId);
        }
        if ($estateId !== null) {
            $queryBuilder->setRelatedEstateId($estateId);
        }
        $queryBuilder->render();

        return $this->handleSend($queryBuilder, 'der Todo');
    }

    public function createRelation($relation, $estateRecordId, $addressRecordId)
    {
        switch ($relation) {
            case 'contactPerson':
            default:
                $relationType = self::RELATION_TYPE_CONTACT_PERSON;
                break;
            case 'buyer':
                $relationType = self::RELATION_TYPE_BUYER;
                break;
            case 'renter':
                $relationType = self::RELATION_TYPE_TENANT;
                break;
            case 'owner':
                $relationType = self::RELATION_TYPE_OWNER;
                break;
                // case 'interested':
                //     //$relationType = self::RELATION_TYPE_COMPLEX_ESTATE_UNITS;
                //     break;
        }

        $queryBuilder = new OnOfficeQueryBuilderCreate('relation');

        $queryBuilder
            ->setRelationType($relationType)
            ->setParentIds($estateRecordId)
            ->setChildIds($addressRecordId);

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'der Estate Relation');
    }

    public function createActivity(array $addressIds, ?int $estateId, string $actionKind, string $actionType, string $note): array
    {
        $queryBuilderCreate = new OnOfficeQueryBuilderCreate('agentslog');

        $queryBuilderCreate->setAddressIds($addressIds)
            ->setActionKind($actionKind)
            ->setActionType($actionType)
            ->setNote($note);

        if ($estateId !== null) {
            $queryBuilderCreate->setEstateId($estateId);
        }

        $queryBuilderCreate->render();

        return $this->handleSend($queryBuilderCreate, 'der Activity');
    }

    public function createCalendarEntry(array $addressIds, ?int $estateId, $data, string $appointmentId, string $startDate, string $endDate, string $description): array
    {
        $data =
            [
                'description' => $data['service']['name'],
                'note' => 'Buchung-Id: '.$appointmentId.' '.$description,
                'start_dt' => $startDate,
                'end_dt' => $endDate,
            ];

        $queryBuilderCreate = new OnOfficeQueryBuilderCreate('address');

        $queryBuilderCreate
            ->setData($data)
            ->setRelatedAddressId($addressIds)
            ->setRelatedEstateId($estateId)
            ->setRelatedSucscriberId($addressIds);

        $queryBuilderCreate
            ->render();

        return $this->handleSend($queryBuilderCreate, 'calendar');
    }

    public function handleSend($queryBuilder, $module)
    {
        $response = $this->api->send($queryBuilder);

        if (! empty($response['status']['errorcode'])) {
            $message = ' Fehler: '.$response['status']['message'];

            throw new OnOfficeApiCreateException($message);
        }
        if (! empty($response) && isset($response['response']['results'][0]['data']['records'])) {
            return $response['response']['results'] ?? [];
        } else {
            return $response;
        }
    }
}
