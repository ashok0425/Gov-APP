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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    's3' => [
        'url' => env('S3_URL'),
    ],
  'sms' => [
        'token' => env('SMS_TOKEN'),
        'identity' => env('SMS_IDENTITY'),

    ],
    'google' => [
        'client_id' => '623644980909-8qgkf0q98umi3cah3tj41u94ffq7el9g.apps.googleusercontent.com',
        'client_secret' => '_X1WjvqIuLeTpxXvFK4F4-6c',
        'redirect' => 'https://rumorhasitnepal.com/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '973081543479024',
        'client_secret' => 'cfd6e0c9fe7688c29a5c884b72262d51',
        'redirect' => 'https://rumorhasitnepal.com/auth/facebook/callback',
    ],
];
