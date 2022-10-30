<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
       'client_id' => '428862777674439',              // Your Facebook Client ID
       'client_secret' => '8c7dca6c92770d4d9a529b6a45085117', // Your Facebook Client Secret
       'redirect' => 'https://timesheets.firstchoicelabour.com.au/index.php/login/facebook/callback',
    ],

    'google' => [
       'client_id' => '1004776036907-icm5soi2u3fmcb7k51bbnmuc8ns2314k.apps.googleusercontent.com',         // Your Google Client ID
       'client_secret' => 'SK8c5OG1XkPmRxjqNDAZtv1t', // Your Google Client Secret
       'redirect' => 'https://timesheets.firstchoicelabour.com.au/index.php/login/google/callback',
    ],

];
