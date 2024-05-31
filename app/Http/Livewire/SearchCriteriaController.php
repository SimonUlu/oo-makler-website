<?php

namespace App\Http\Livewire;

use App\Mail\SearchCriteriaMailable;
use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use App\Services\OnOfficeService;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Statamic\Facades\GlobalSet;

class SearchCriteriaController extends Component
{
    public $currentStep = 1;

    public $form = [
        'objektart' => null,
        'von' => null,
        'bis' => null,
        'wohnflaeche__von' => null,
        'wohnflaeche__bis' => null,
        'kaufpreis__von' => null,
        'kaufpreis__bis' => null,
        'vermarktungsart' => null,
        'plz_range' => null,
        'plz_start_from' => null,
        'salutation' => null,
        'firstname' => null,
        'lastname' => null,
        'street' => null,
        'postalcode' => null,
        'location' => null,
        'email' => null,
        'phone' => null,
        'message' => null,
        'kontaktaufnahme' => false,
        'datenschutz' => false,
    ];

    protected $rulesStep2 = [
        'form.firstname' => 'required|string|max:255',
        'form.lastname' => 'required|string|max:255',
        'form.email' => 'required|email',
    ];

    protected $rulesStep1 = [
        'form.vermarktungsart' => 'required|string|in:kauf,miete',
        'form.objektart' => 'required|string|in:haus,wohnung',
        'form.plz_range' => 'required|numeric',
        'form.plz_start_from' => 'required|numeric',
        'form.kaufpreis__von' => 'required|numeric',
        'form.kaufpreis__bis' => 'required|numeric',
        'form.wohnflaeche__von' => 'required|numeric',
        'form.wohnflaeche__bis' => 'required|numeric',
        'form.anzahl_zimmer__von' => 'required|numeric',
        'form.anzahl_zimmer__bis' => 'required|numeric',
    ];

    protected $rulesStep3 = [
        'form.message' => 'nullable|string|max:255',
        'form.kontaktaufnahme' => 'required|accepted',
        'form.datenschutz' => 'required|accepted',
    ];

    public function messages()
    {
        return [
            'form.firstname.required' => 'Bitte geben Sie Ihren Vornamen an.',
            'form.firstname.string' => 'Ihr Vorname darf keine Zahlen enthalten.',
            'form.firstname.max' => 'Ihr Vorname darf nicht länger als 255 Zeichen sein.',
            'form.lastname.required' => 'Bitte geben Sie Ihren Nachnamen an.',
            'form.lastname.string' => 'Ihr Nachname darf keine Zahlen enthalten.',
            'form.lastname.max' => 'Ihr Nachname darf nicht länger als 255 Zeichen sein.',
            'form.email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse an.',
            'form.email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
            'form.phone.required' => 'Bitte geben Sie Ihre Telefonnummer an.',
            'form.phone.numeric' => 'Ihre Telefonnummer darf nur Zahlen enthalten.',
            'form.objektart.required' => 'Bitte geben Sie die Objektart an.',
            'form.objektart.string' => 'Die Objektart darf keine Zahlen enthalten.',
            'form.vermarktungsart.required' => 'Bitte geben Sie die Vermarktungsart an.',
            'form.vermarktungsart.string' => 'Die Vermarktungsart darf keine Zahlen enthalten.',
            'form.plz_start_from.required' => 'Bitte geben Sie die Postleitzahl an.',
            'form.plz_start_from.numeric' => 'Die Postleitzahl darf nur Zahlen enthalten.',
            'form.plz_range.required' => 'Bitte geben Sie den Umkreis an.',
            'form.plz_range.numeric' => 'Der Umkreis darf nur Zahlen enthalten.',
            'form.anzahl_zimmer__von.required' => 'Bitte geben Sie die minimale Anzahl der Zimmer an.',
            'form.anzahl_zimmer__bis.required' => 'Bitte geben Sie die maximale Anzahl der Zimmer an.',
            'form.anzahl_zimmer__von.numeric' => 'Die Anzahl der Zimmer darf nur Zahlen enthalten.',
            'form.anzahl_zimmer__bis.numeric' => 'Die Anzahl der Zimmer darf nur Zahlen enthalten.',
            'form.kaufpreis__von.required' => 'Bitte geben Sie einen minamalen Kaufpreis an.',
            'form.kaufpreis__von.numeric' => 'Der Kaufpreis darf nur Zahlen enthalten.',
            'form.kaufpreis__bis.numeric' => 'Der Kaufpreis darf nur Zahlen enthalten.',
            'form.wohnflaeche__von.required' => 'Bitte geben Sie eine minamale Wohnflaeche an.',
            'form.wohnflaeche__von.numeric' => 'Die Wohnfläche darf nur Zahlen enthalten.',
            'form.kaufpreis__bis.required' => 'Bitte geben Sie einen maximalen Kaufpreis an.',
            'form.wohnflaeche__bis.required' => 'Bitte geben Sie eine maximale Wohnflaeche an.',
            'form.wohnflaech__bis.numeric' => 'Die Wohnfläche darf nur Zahlen enthalten.',
            'form.message.max' => 'Ihre Nachricht darf nicht länger als 255 Zeichen sein.',
            'form.kontaktaufnahme.required' => 'Damit wir Ihre Anfrage verarbeiten können, benötigen wir Ihre Einwilligung zur Kontaktaufnahme.',
            'form.kontaktaufnahme.accepted' => 'Damit wir Ihre Anfrage verarbeiten können, benötigen wir Ihre Einwilligung zur Kontaktaufnahme.',
            'form.datenschutz.required' => 'Damit wir Ihre Anfrage verarbeiten können, benötigen wir Ihre Einwilligung zur Datenverarbeitung.',
            'form.datenschutz.accepted' => 'Damit wir Ihre Anfrage verarbeiten können, benötigen wir Ihre Einwilligung zur Datenverarbeitung.',
        ];
    }

    public function incrementStep(): void
    {
        // Depending on current step, apply different set of rules
        if ($this->currentStep == 1) {
            $this->validate($this->rulesStep1);
        } elseif ($this->currentStep == 2) {
            $this->validate($this->rulesStep2);
        }

        // If validation is successful, only then increment the step
        $this->currentStep++;
    }

    public function submit(OnOfficeService $onofficeService): void
    {
        $this->validate($this->rulesStep3);
        $this->resetValidation();

        // create or update address user
        $addressId = $this->createOrUpdateAddress($this->form);

        // add search criteria
        $result = $this->createSearchCriteria($addressId, $this->form, $onofficeService);

        if (isset($result[0]['status']['errorcode']) && $result[0]['status']['errorcode'] != 0) {
            // send user to site creation error site
            redirect()->route('searchcriteria.error');
        }

        // send user to site creation success site
        redirect()->route('searchcriteria.success');

        // If validation was successful, then process the data
    }

    public function render()
    {
        return view('livewire.search-criteria-controller');
    }

    public function createOrUpdateAddress(array $form)
    {
        $parameters = array_filter([
            'Email' => $form['email'],
            'Vorname' => $form['firstname'] ?? null,
            'Name' => $form['lastname'] ?? null,
        ]);

        $filter = [
            'Email' => [
                ['op' => '=', 'val' => $form['email']],
            ],
            'Vorname' => [
                ['op' => '=', 'val' => $form['first_name'] ?? null],
            ],
            'Name' => [
                ['op' => '=', 'val' => $form['last_name'] ?? null],
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

        if ($result['status']['errorcode'] == 0 || $result['data']['records'][0]['elements']['success'] !== 'success' && $result['status']['errorcode']) {
            return (int) $result['data']['records'][0]['id'];
        }

        if ($result['data']['records'][0]['elements']['success'] !== 'success') {
            return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
        }

        return (int) $result['resourceid'];
    }

    public function createSearchCriteria(int $addressId, array $form, OnOfficeService $onofficeService)
    {
        $criteria = [
            'objektart' => $form['objektart'],
            'anzahl_zimmer__von' => $form['anzahl_zimmer__von'],
            'anzahl_zimmer__bis' => $form['anzahl_zimmer__bis'],
            'wohnflaeche__von' => $form['wohnflaeche__von'],
            'wohnflaeche__bis' => $form['wohnflaeche__bis'],
            'kaufpreis__von' => $form['kaufpreis__von'],
            'kaufpreis__bis' => $form['kaufpreis__bis'],
            'vermarktungsart' => $form['vermarktungsart'],
            'range_plz' => $form['plz_start_from'],
            'range' => $form['plz_range'],
            'krit_bemerkung_oeffentlich' => $form['message'],
            // TODO: make advisor configurable
            'advisor' => 23,
        ];

        $criteriaEmail['title_request'] = 'Suchauftrag';

        $person = [
            'addressId' => $addressId,
            'anrede' => $form['salutation'] ?? null,
            'title' => $form['title'] ?? null,
            'email' => $form['email'],
            'vorname' => $form['firstname'] ?? null,
            'name' => $form['lastname'] ?? null,
            'strasse' => $form['street'] ?? null,
            'hausnummer' => $form['house_number'] ?? null,
            'plz' => $form['zip_code'] ?? null,
            'ort' => $form['city'] ?? null,
            'phone' => $form['phone'] ?? null,
            'datenschutz' => $form['datenschutz'] ?? null,
            'kontaktaufnahme' => $form['kontaktaufnahme'] ?? null,
            'message' => $form['message'] ?? null,
        ];

        // create or update address user
        $addressId = $this->createOrUpdateAddress($form);
        $formData = array_merge($criteria, $person);

        try {
            $result = $onofficeService->create()->searchCriteria($criteria, $addressId);
        } catch (\Exception $e) {
            Mail::to(GlobalSet::find('onoffice')->in('default')->get('e-mail_inbox_formulare'))->queue(
                new SearchCriteriaMailable([
                    'formData' => $formData,
                    'searchCriteria' => $criteriaEmail,
                ])
            );
        }

        return true;
    }
}
