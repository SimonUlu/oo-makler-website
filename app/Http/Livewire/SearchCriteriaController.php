<?php

namespace App\Http\Livewire;

use App\Mail\SearchCriteriaMailable;
use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use App\Services\OnOfficeService;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Component;
use Statamic\Entries\Collection;
use Statamic\Facades\GlobalSet;

class SearchCriteriaController extends Component
{
    public $currentStep = 1;

    public $region = [];

    public $vermarktungsart = null;

    public $plz_disable = false;

    public $region_enabled = false;

    public $vermarktungsOptions = ['haus' => 'Haus', 'wohnung' => 'Wohnung', 'grundstueck' => 'Grundstück'];

    private $regionOptions = [
        //        ['value' => 'Nord', 'label' => 'Nord'],
        //        ['value' => 'West', 'label' => 'West'],
        //        ['value' => 'Ost', 'label' => 'Ost'],
    ];

    public $form = [
        'objektart' => null,
        'wohnflaeche__von' => null,
        'wohnflaeche__bis' => null,
        'kaufpreis__von' => null,
        'kaufpreis__bis' => null,
        'grundstuecksflaeche__von' => null,
        'grundstuecksflaeche__bis' => null,
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
        'form.vermarktungsart' => 'nullable|string|in:kauf,miete',
        'form.objektart' => 'required|string|in:haus,wohnung,grundstueck',
        'form.plz_range' => 'nullable|numeric',
        'form.plz_start_from' => 'nullable|numeric',
        'form.kaufpreis__von' => 'required|numeric',
        'form.kaufpreis__bis' => 'required|numeric',
        'form.wohnflaeche__von' => 'nullable|numeric',
        'form.wohnflaeche__bis' => 'nullable|numeric',
        'form.anzahl_zimmer__von' => 'nullable|numeric',
        'form.anzahl_zimmer__bis' => 'nullable|numeric',
        'form.grundstuecksflache__von' => 'nullable|numeric',
        'form.grundstuecksflache__bis' => 'nullable|numeric',

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
            'form.plz_start_from.required' => 'Bitte geben Sie die Postleitzahl an.',
            'form.plz_start_from.numeric' => 'Die Postleitzahl darf nur Zahlen enthalten.',
            'form.plz_range.required' => 'Bitte geben Sie den Umkreis an.',
            'form.plz_range.numeric' => 'Der Umkreis darf nur Zahlen enthalten.',
            'form.anzahl_zimmer__von.numeric' => 'Die Anzahl der Zimmer darf nur Zahlen enthalten.',
            'form.anzahl_zimmer__bis.numeric' => 'Die Anzahl der Zimmer darf nur Zahlen enthalten.',
            'form.kaufpreis__von.required' => 'Bitte geben Sie einen minimalen Kaufpreis an.',
            'form.kaufpreis__von.numeric' => 'Der Kaufpreis darf nur Zahlen enthalten.',
            'form.kaufpreis__bis.numeric' => 'Der Kaufpreis darf nur Zahlen enthalten.',
            'form.kaufpreis__bis.required' => 'Bitte geben Sie einen maximalen Kaufpreis an.',
            'form.grundstuecksflaeche__von.numeric' => 'Die Grundstücksfläche darf nur Zahlen enthalten.',
            'form.grundstuecksflaeche__bis.numeric' => 'Die Grundstücksfläche darf nur Zahlen enthalten.',
            'form.wohnflaeche__von.numeric' => 'Die Wohnfläche darf nur Zahlen enthalten.',
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

    public function setObjektart(string $value): void
    {
        $this->form['objektart'] = $value;
        $this->form['plz_range'] = null;
        $this->form['plz_start_from'] = null;
        $this->form['kaufpreis__von'] = null;
        $this->form['kaufpreis__bis'] = null;
        $this->form['wohnflaeche__von'] = null;
        $this->form['wohnflaeche__bis'] = null;
        $this->form['anzahl_zimmer__von'] = null;
        $this->form['anzahl_zimmer__bis'] = null;
        $this->form['grundstuecksflaeche__von'] = null;
        $this->form['grundstuecksflaeche__bis'] = null;
    }

    public function decrementStep(): void
    {
        if ($this->currentStep <= 1) {
            return;
        }
        $this->currentStep -= 1;

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

    private function getRegions()
    {
        $estate_fields = Collection::find('estate_regions')->queryEntries()->get();
        foreach ($estate_fields as $estate_field) {
            //            array_push($this->regionOptions, ['value' => $estate_field['id'], 'label' => $estate_field['name']]);
            $neighborhoods = json_decode($estate_field['children']);
            foreach ($neighborhoods as $neighborhood) {
                array_push(
                    $this->regionOptions,
                    ['value' => $neighborhood->id, 'label' => $estate_field['name'].'>>'.$neighborhood->name]);
            }
        }

    }

    public function render(): View
    {
        if ($this->region_enabled) {
            $this->getRegions();
        }

        return view('livewire.search-criteria-controller',
            [
                'vermarktungsart' => $this->vermarktungsart,
                'vermarktungsOptions' => $this->vermarktungsOptions,
                'regionOptions' => $this->regionOptions,
                'currentStep' => $this->currentStep,
            ]);
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
            'grundstuecksflaeche__von' => $form['grundstuecksflaeche__von'],
            'grundstuecksflaeche__bis' => $form['grundstuecksflaeche__bis'],
            'vermarktungsart' => $this->vermarktungsart ?? $form['vermarktungsart'] ?? 'kauf',
            'krit_bemerkung_oeffentlich' => $form['message'],
            'advisor' => 23,
        ];
        if ($this->region_enabled) {
            $criteria['regionaler_zusatz'] = implode(',', array_values($this->region));
        }
        if (! $this->plz_disable) {
            $criteria['plz'] = $form['plz_start_from'];
            $criteria['plz_range'] = $form['plz_range'];
        }

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
