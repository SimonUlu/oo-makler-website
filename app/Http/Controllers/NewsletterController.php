<?php

namespace App\Http\Controllers;

use App\Services\OnOfficeApiHelpers\UpdateOrCreateAddressHelper;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $parameters = array_filter([
            'Email' => strtolower($request->email),
            'Vorname' => $request->firstname ?? null,
            'Name' => $request->lastname ?? null,
        ]);

        $filter = [
            'Email' => [
                ['op' => '=', 'val' => strtolower($request->email)],
            ],
        ];

        // unset filter where val is null
        foreach ($filter as $key => $value) {
            if ($value[0]['val'] == null) {
                unset($filter[$key]);
            }
        }

        $addressHandler = new UpdateOrCreateAddressHelper();

        $result = $addressHandler->updateOrCreateNewsletter(
            parameters: $parameters,
            filter: $filter
        );

        if ($result['data']['records'][0]['elements']['success'] == 'success' || $result['status']['errorcode'] == 0) {
            return redirect()->route('newsletter.success');
        }

        // send user to site newsletter-erfolgreich-angemeldet
        return back()->with('error', 'Da hat etwas nicht geklappt. Bitte versuchen Sie es bitte später erneut.');
    }
}
