<?php

return [
    'cookie_key' => '__cookie_consent',
    'cookie_value_analytics' => '2',
    'cookie_value_marketing' => '3',
    'cookie_value_both' => 'true',
    'cookie_value_none' => 'false',
    'cookie_expiration_days' => '365',
    'gtm_event' => 'cookie_refresh',
    'ignored_paths' => [
        'cookie-consent',
        'cookie-consent/accept',
        'cookie-consent/decline',
        'cookie-consent/reset',
    ],
    'policy_url_de' => env('COOKIE_POLICY_URL_DE', '/datenschutz'),
    'policy_url_en' => env('COOKIE_POLICY_URL_EN', '/datenschutz'),
    'policy_url_fr' => env('COOKIE_POLICY_URL_FR', '/datenschutz'),
    'policy_url_nl' => env('COOKIE_POLICY_URL_NL', '/datenschutz'),
];
