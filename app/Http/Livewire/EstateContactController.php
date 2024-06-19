<?php

namespace App\Http\Livewire;

use App\Http\Livewire\ContactBase\FormComponent;
use App\Mail\EstateContactMailable;
use App\Services\StringParseService\LibPostal;
use App\Services\StringParseService\NameParser;
use Illuminate\Support\Facades\Mail;
use Statamic\Facades\GlobalSet;

class EstateContactController extends FormComponent
{
    private $estate;

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
            $estateData['estate_strasse'] = $this->estate['elements']['strasse'].' '.$this->estate['elements']['hausnummer'];
        } else {
            $estateData = [];
        }

        $data = array_merge($addressData, $estateData);
        Mail::to(GlobalSet::find('onoffice')->in('default')->get('e-mail_inbox_expose-mails'))->queue(
            new EstateContactMailable([
                // 'xmlString' => $xmlString,
                'formData' => $data,
                'estateData' => $estateData,
                'addressData' => $addressData,
            ])
        );

        $this->reset();
        session()->flash('success', 'Sie erhalten in Kürze weitere Informationen per E-Mail!');
    }

    public function render()
    {
        return view('livewire.estate-contact-controller');
    }
}
