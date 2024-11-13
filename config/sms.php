<?php

return [
    'default' => env('SMS_DRIVER', 'infobip'),

    'drivers' => [
        'twilio' => [
            'class' => App\Services\TwilioService::class,
            'config' => [
                'sid' => env('TWILIO_ACCOUNT_SID'),
                'auth_token' => env('TWILIO_AUTH_TOKEN'),
                'from' => env('TWILIO_PHONE'),
            ],
        ],

        'infobip' => [
            'class' => App\Services\InfobipService::class,
            'config' => [
                'api_key' => env('INFOBIP_API_KEY'),  // Récupération correcte de la clé API
                'api_url' => env('INFOBIP_API_URL'),  // Récupération correcte de l'URL API
            ],
        ],
    ],
];
