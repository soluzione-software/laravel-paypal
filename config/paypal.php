<?php

return [
    'base_url' => env('PAYPAL_BASE_URL', 'https://api.paypal.com/v1'),

    'client_id' => env('PAYPAL_CLIENT_ID'),

    'secret' => env('PAYPAL_SECRET'),

    'webhook_id' => env('PAYPAL_WEBHOOK_ID'),

    'routes_prefix' => '/paypal-api',
];
