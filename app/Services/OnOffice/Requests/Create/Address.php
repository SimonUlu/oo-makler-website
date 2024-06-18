<?php

namespace App\Services\OnOffice\Requests\Create;

use App\Services\OnOffice\Enums\ContactCategory;
use App\Services\OnOffice\Enums\Kontaktart;
use App\Services\OnOffice\Requests\AbstractRequest;

class Address extends AbstractRequest
{
    //const COLUMN_SENDERSOFTWARE = 'ind_2328_Feld_adressen0'; // for test tenant
    const COLUMN_SENDERSOFTWARE = 'ind_2332_Feld_adressen0';

    public function __construct($actionId = self::ACTION_ID_CREATE)
    {
        parent::__construct($actionId, 'address');
    }

    public function setParams(array $params): Address
    {
        $this->parameters = $params;

        return $this;
    }

    public function setImportId(string $value): Address
    {
        $this->parameters['importId'] = $value;

        return $this;
    }

    public function setContactCategory(ContactCategory $category): Address
    {
        $this->parameters['contactCategory'] = $category->value;

        return $this;
    }

    public function setEMail(string $value): Address
    {
        $this->parameters['email'] = $value;

        return $this;
    }

    public function setAddition1(string $value): Address
    {
        $this->parameters['Zusatz1'] = $value;

        return $this;
    }

    public function setKontaktart(Kontaktart|array $value): Address
    {
        if (is_array($value)) {
            $artDaten = [];
            foreach ($value as $item) {
                $artDaten[] = $item->value;
            }
        } else {
            $artDaten = $value->value;
        }
        $this->parameters['ArtDaten'] = $artDaten;

        return $this;
    }

    public function setSendersoftware(string $value): Address
    {
        $this->parameters[self::COLUMN_SENDERSOFTWARE] = $value;

        return $this;
    }

    public function setVorname(string $value): Address
    {
        $this->parameters['Vorname'] = $value;

        return $this;
    }

    public function setName(string $value): Address
    {
        $this->parameters['Name'] = $value;

        return $this;
    }

    public function setPlz(string $value): Address
    {
        $this->parameters['Plz'] = $value;

        return $this;
    }
}
