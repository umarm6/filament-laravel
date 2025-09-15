<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vocus API Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for Vocus API.
    | You can set the values in your .env file.
    |
    */


    'username' => env('VOCUS_USERNAME', ''),
    'password' => env('VOCUS_PASSWORD', ''),
    'base_url' => env('VOCUS_BASE_URL', 'https://extranet.asmorphic.com/api'),
];
