<?php

namespace App\Helpers\Contacts;

class AddressHelper
{
    protected $updateOrCreateAddressHelper;

    public function __construct($updateOrCreateAddressHelper)
    {
        $this->updateOrCreateAddressHelper = $updateOrCreateAddressHelper;
    }

    public function createOrUpdateAddress(array $form)
    {
        $parameters = array_filter([
            'Email' => $form['email'],
            'Vorname' => $form['vorname'] ?? null,
            'Name' => $form['name'] ?? null,
            'Strasse' => isset($form['strasse']) ? $form['strasse'].''.(isset($form['hausnummer']) ? $form['hausnummer'] : '') : null,
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

        $result = $this->updateOrCreateAddressHelper->updateOrCreate(
            parameters: $parameters,
            filter: $filter
        );

        if (isset($result['status']) && $result['status']['errorcode'] !== 0 && $result['data']['records'][0]['elements']['success'] !== 'success') {
            return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
        }

        return (isset($result['resourceid']) && ! empty($result['resourceid'])) ? $result['resourceid'] : $result['data']['records'][0]['id'] ?? null;
    }
}
