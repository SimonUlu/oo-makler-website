<?php

namespace App\Http\Livewire;

use App\Helpers\Contacts\AddressHelper;
use App\Helpers\Contacts\ContactHelper;
use App\Http\Livewire\ContactBase\FormComponent;
use App\Services\OnOfficeApiHelpers\AgentslogHelper;
use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use App\Services\StringParseService\LibPostal;
use App\Services\StringParseService\NameParser;

class EstateContactController extends FormComponent
{
    public $estate;

    public $estateId;

    public $formId;

    public $title;

    public $style;

    public $defaultMessage;

    public function mount($estate)
    {
        $this->estate = $estate;
        if ($this->defaultMessage != null) {
            $this->form['message'] = $this->defaultMessage;
        }
    }

    public function submitForm()
    {
        $this->validate();

        $formData = array_filter([
            ...NameParser::parseName($this->form['name']),
            'email' => $this->form['email'],
            ...LibPostal::parseAddress($this->form['address']),
            'phone' => $this->form['phone'] ?? '',
            'message' => $this->form['message'] ?? '',
        ]);

        $addressData = array_filter([
            'address_anrede' => $formData['anrede'] ?? null,
            'address_vorname' => $formData['vorname'] ?? null,
            'address_name' => $formData['name'] ?? null,
            'address_email' => $formData['email'] ?? null,
            'address_strasse' => ($formData['street'] ?? '').' '.($formData['house_number'] ?? ''),
            'address_plz' => $formData['zip_code'] ?? null,
            'address_ort' => $formData['city'] ?? null,
            'address_message' => $formData['message'] ?? null,
        ]);

        if (! empty($this->estate)) {
            $estateData['estate_oobj_id'] = $this->estate['elements']['objektnr_extern'] ?? null;
            $estateData['estate_objekttitel'] = $this->estate['elements']['objekttitel'] ?? null;
            $estateData['estate_plz'] = $this->estate['elements']['plz'] ?? null;
            $estateData['estate_ort'] = $this->estate['elements']['ort'] ?? null;
            if (isset($this->estate['elements']['strasse'])) {
                $estateData['estate_strasse'] = $this->estate['elements']['strasse'].' '.$this->estate['elements']['hausnummer'];
            }
        } else {
            $estateData = [];
        }

        // create instance of helper class
        $updateOrCreateAddressHelper = new UpdateOrCreateAddressHelper();

        // create new instance of address helper class and create Id
        $addressHelper = new AddressHelper($updateOrCreateAddressHelper);
        $addressId = $addressHelper->createOrUpdateAddress($formData);

        // write activity in onOffice
        $activityHandler = new AgentslogHelper();

        $activityHandler->createAgentslogEntry(
            addressIds: [$addressId],
            estateId: $this->estate['id'],
            actionKind: 'System',
            actionType: 'Kontakt zugeführt',
            note: 'Anfrage Website '.($this->onofficeNote ?? '').($this->form['message'] ?? ''),
        );

        // get addressId
        $addressData['addressId'] = $addressId;

        ContactHelper::sendEstateMail($addressData, $estateData);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.estate-contact-controller');
    }
}
