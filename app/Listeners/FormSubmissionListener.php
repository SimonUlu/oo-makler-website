<?php

namespace App\Listeners;

use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use Illuminate\Support\Facades\Session;
use Statamic\Events\SubmissionCreated;

class FormSubmissionListener
{
    public function handle(SubmissionCreated $event)
    {
        $submission = $event->submission;

        // handle forms
        if ($submission->form()->handle() == 'newsletter') {
            $this->handleNewsletter($submission);
        }

        return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
    }

    public function handleNewsletter($submission)
    {

        $formData = $submission->data();
        $parameters = array_filter([
            'Email' => $formData['email'],
            'Vorname' => $formData['first_name'] ?? null,
            'Name' => $formData['last_name'] ?? null,
        ]);

        $filter = [
            'Email' => [
                ['op' => '=', 'val' => $formData['email']],
            ],
            'Vorname' => [
                ['op' => '=', 'val' => $formData['first_name'] ?? null],
            ],
            'Name' => [
                ['op' => '=', 'val' => $formData['last_name'] ?? null],
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

        if ($result !== 'success') {
            return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
        }

        Session::flash('newsletter.success', true);
    }
}
