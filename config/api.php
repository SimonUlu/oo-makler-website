<?php

return [

    /*
    |--------------------------------------------------------------------------
    | onOffice Authentication
    |--------------------------------------------------------------------------
    |
    | This option returns token and secret for onOffice.
    |
    */
    'onoffice' => [

        /*
    |--------------------------------------------------------------------------
    | Api Sandbox Authentication
    |--------------------------------------------------------------------------
    |
    | This option returns token and secret for sandbox authentication.
    |
    */
        'sandbox' => [
            'token' => env('ONOFFICE_API_SANDBOX_TOKEN'),
            'secret' => env('ONOFFICE_API_SANDBOX_SECRET'),
        ],
    ],

    'google' => [
        'maps' => [
            'key' => env('GOOGLE_API_KEY'),
        ],
    ],

    'mapbox' => [
        'key' => env('MAPBOX_API_KEY'),
    ],
];
