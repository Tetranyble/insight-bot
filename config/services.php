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

    'json' => [
        'url' => env('JSON_ENDPOINT', 'https://jsonplaceholder.typicode.com/'),
        'key' => env('JSON_KEY', ''),
    ],
    'nibss' => [
        'app_name' => env('NIBSS_APP_NAME', ''),
        'client_id' => env('NIBSS_CLIENT_ID', ''),
        'client_secret' => env('NIBSS_CLIENT_SECRET', ''),
        'api_key' => env('NIBSS_API_KEY', ''),
        'base_url' => env('NIBSS_BASE_URL', '')
    ],

    'bone' => [
        'project_name' => env('BONE_PROJECT_NAME', ''),
        'client_name' => env('BONE_CLIENT_NAME', ''),
        'auth_token' => env('BONE_AUTHTOKEN', ''),
        'institution_code' => env('BONE_INSTITUTION_CODE', ''),
        'base_url' => env('BONE_BASE_URL', '')
    ],

];
