<?php

namespace App\Http\Livewire;

use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use Livewire\Component;

class NewsletterContactController extends Component
{
    public $form;

    protected $rules = [
        'form.email' => 'required|email',
    ];

    public function messages()
    {
        return [
            'form.email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse ein.',
            'form.email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
        ];
    }

    public function render()
    {
        return view('livewire.newsletter-contact-controller');
    }

    public function submitForm()
    {
        $this->validate();

        $formData = array_filter([
            'email' => $this->form['email'],
        ]);

        // create or update address user
        $this->createOrUpdateAddress($formData);

        $this->reset();
        session()->flash('success', 'Sie haben sich erfolgreich angemeldet und werden in Kürze eine E-Mail zur Bestätigung erhalten.');
    }

    public function createOrUpdateAddress(array $form)
    {
        $parameters = array_filter([
            'Email' => $form['email'],
            'Vorname' => $form['vorname'] ?? null,
            'Name' => $form['name'] ?? null,
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

        $result = $addressHandler->updateOrCreateNewsletter(
            parameters: $parameters,
            filter: $filter
        );

        if ($result['status']['errorcode'] !== 0 && $result['data']['records'][0]['elements']['success'] !== 'success') {
            return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
        }

        return (int) $result['resourceid'];
    }
}
