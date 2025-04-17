<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'africastalking' => [
        'username' => env('AT_USERNAME'),
        'key' => env('AT_KEY'),
        'from' => env('AT_FROM'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://example.com/callback-url',
    ],

    'termii' => [
        'sender_id' => env('TERMII_SENDER_ID'),
        'api_key' => env('TERMII_API_KEY'),
        'channel' => env('TERMII_MESSAGE_CHANNEL'),
        'attempts' => env('TERMII_MESSAGE_ATTEMPTS'),
        'time_to_live' => env('TERMII_MESSAGE_TIME_TO_LIVE'),
        'type' => env('TERMII_MESSAGE_TYPE'),
    ],

    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'base_url' => env('PAYSTACK_PAYMENT_URL'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
    ],

];
