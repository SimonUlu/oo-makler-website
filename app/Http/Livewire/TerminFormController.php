<?php

namespace App\Http\Livewire;

use App\Http\Livewire\ContactBase\FormComponent;
use App\Mail\ContactFormMailable;
use App\Services\OnOfficeApiHelpers\AgentslogHelper;
use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use App\Services\StringParseService\LibPostal;
use App\Services\StringParseService\NameParser;
use Illuminate\Support\Facades\Mail;
use Statamic\Facades\GlobalSet;

class TerminFormController extends FormComponent
{
    public $formId;

    public $title;

    public $style;

    public $defaultMessage;

    public $time;

    public $contactType;

    public $sendToMail;

    public $onofficeNote;

    public function mount()
    {
        $this->rules['phone']=['required|regex:/^\+?\d{4,20}$/'];
        if ($this->defaultMessage != null) {
            $this->form['message'] = $this->defaultMessage;
        }
        if ($this->title != null) {
            $this->form['title'] = $this->title;
        }

        $this->contactType = GlobalSet::find('onoffice')->in('default')->get('contact_type');
        $this->sendToMail = GlobalSet::find('onoffice')->in('default')->get('e-mail_inbox_formulare');
    }

    public function render()
    {
        return view('livewire.termin-form-controller');
    }

    public function submitForm()
    {
        $this->validate();

        //check for potential spam
        if ($this->form['honey']) {
            return redirect('');
        } else {
            if ($this->contactType === 'standard') {
                try {
                    // Versuchen Sie, den Bericht zu senden und speichern Sie das Ergebnis
                    $result = $this->sendStandardMail($this->form);
                    if ($result !== true) {
                        // Wenn sendReport() etwas anderes als TRUE zurückgibt, leiten Sie den Nutzer auf die Fehlerseite weiter
                        redirect()->route('searchcriteria.error');
                    }
                    // Leiten Sie den Nutzer auf die Erfolgsseite weiter
                    redirect()->route('contact.success');
                } catch (\Exception $e) {
                    session()->flash('error', 'Ein Fehler ist aufgetreten: '.$e->getMessage());
                    redirect()->route('searchcriteria.error');
                }
            } else {
                $address = [];

                if (! empty($this->form['address'])) {
                    $address = LibPostal::parseAddress($this->form['address'])->toArray();
                }

                $formData = array_filter([
                    ...NameParser::parseName($this->form['name']),
                    'email' => $this->form['email'],
                    'phone' => $this->form['phone'] ?? '',
                    'message' => $this->form['message'] ?? '',
                ]);

                if (! empty($address)) {
                    $formData = array_merge($formData, $address);
                }

                $addressData = array_filter([
                    'title_request' => ! empty($this->title) ? $this->title : 'Kein Seitentitel',
                    'anrede' => $formData['anrede'] ?? null,
                    'vorname' => $formData['vorname'] ?? null,
                    'name' => $formData['name'] ?? null,
                    'email' => $formData['email'] ?? null,
                    'strasse' => $formData['street'] ?? null,
                    'hausnummer' => $formData['house_number'] ?? null,
                    'plz' => $formData['zip_code'] ?? null,
                    'ort' => $formData['city'] ?? null,
                    'message' => $formData['message'] ?? null,
                    'phone' => $formData['phone'] ?? null,
                ]);

                // create or update address user
                $addressId = $this->createOrUpdateAddress($addressData);

                // write activity in onOffice
                $activityHandler = new AgentslogHelper();

                $activityHandler->createAgentslogEntry(
                    addressIds: [$addressId],
                    estateId: null,
                    actionKind: 'System',
                    actionType: 'Kontakt zugeführt',
                    note: 'Terminanfrage '.($this->onofficeNote ?? '').($this->defaultMessage ?? '').' ',
                );

                // get addressId
                $addressData['addressId'] = $addressId;

                Mail::to(GlobalSet::find('onoffice')->in('default')->get('e-mail_inbox_expose-mails'))->queue(
                    new ContactFormMailable([
                        'formData' => $addressData,
                    ])
                );

                $this->reset();
                session()->flash('success', 'Wir werden uns in Kürze persönlich bei Ihnen melden!');
            }
        }

    }

    public function selectTimeSlot($timeSlot)
    {
        $this->time = $timeSlot;
    }

    public function createOrUpdateAddress(array $form)
    {

        $parameters = array_filter([
            'Email' => $form['email'],
            'Vorname' => $form['vorname'] ?? null,
            'Name' => $form['name'] ?? null,
            'Strasse' => isset($form['strasse']) ? $form['strasse'].' '.(isset($form['hausnummer']) ? $form['hausnummer'] : '') : null,
            'Plz' => $form['plz'] ?? null,
            'Ort' => $form['ort'] ?? null,
            'phone' => $form['phone'] ?? null,
        ]);

        $filter = [
            'Email' => [
                ['op' => '=', 'val' => $form['email']],
            ],
        ];

        // unset filter where val is null
        foreach ($filter as $key => $value) {
            if ($value[0]['val'] === null) {
                unset($filter[$key]);
            }
        }

        $addressHandler = new UpdateOrCreateAddressHelper();

        $result = $addressHandler->updateOrCreate(
            parameters: $parameters,
            filter: $filter
        );

        if (isset($result['status']) && $result['status']['errorcode'] !== 0 && $result['data']['records'][0]['elements']['success'] !== 'success') {
            return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
        }

        return (isset($result['resourceid']) && ! empty($result['resourceid'])) ? $result['resourceid'] : $result['data']['records'][0]['id'] ?? null;
    }

    public function sendStandardMail(array $form)
    {

        try {
            $mailable = new \App\Mail\SimpleContact($form); // Stellen Sie sicher, dass diese Mailable-Klasse existiert und korrekt ist
            Mail::to($this->sendToMail)->send($mailable);

            if (count(Mail::failures()) > 0) {
                throw new \Exception('Fehler beim Senden der E-Mail');
            }

            session()->flash('success', 'Ihre E-Mail wurde erfolgreich gesendet.');

            return true;
        } catch (\Exception $e) {
            // Catch any errors and let the user know
            session()->flash('error', 'Ein Fehler ist aufgetreten: '.$e->getMessage());

            return false;
        }
    }
}
