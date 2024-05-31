<?php

namespace App\Http\Livewire\ContactBase;

use Livewire\Component;

abstract class FormComponent extends Component
{
    public $form = [
        'name' => null,
        'address' => null,
        'email' => null,
        'phone' => null,
        'message' => null,
        'widerruf' => false,
        'honey' => null,
    ];

    protected $rules = [
        'form.name' => 'required',
        'form.address' => 'nullable',
        'form.email' => 'required|email',
        'form.phone' => 'nullable',
        'form.message' => 'nullable',
        'form.widerruf' => 'accepted',
        'form.honey' => 'nullable',
    ];

    public function messages()
    {
        return [
            'form.name.required' => 'Bitte geben Sie Ihren vollständigen Namen ein.',
            'form.address.required' => 'Bitte geben Sie Ihre Adresse ein.',
            'form.email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse ein.',
            'form.email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
            'form.phone.required' => 'Bitte geben Sie Ihre Telefonnummer ein.',
            'form.widerruf.accepted' => 'Bitte akzeptieren Sie die Bedingungen zur Kontaktaufnahme. Ansonsten können wir Ihre Anfrage nicht verarbeiten.',
        ];
    }
}
