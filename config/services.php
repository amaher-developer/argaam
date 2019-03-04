<?php
$lang = 'ar';
if (array_key_exists('REQUEST_URI', $_SERVER)) {
    preg_match('#/(?<lang>ar|en)/?#', $_SERVER['REQUEST_URI'], $match);
    $lang = @$match['lang'] ?: 'ar';
}
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

//    'facebook' => [
//        'client_id' => env('FACEBOOK_CLIENT_ID'),
//        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
//        'redirect' => env('APP_URL') . "/{$lang}/provider_callback",
//    ],
//
//    'google' => [
//        'client_id' => env('GOOGLE_CLIENT_ID'),
//        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
//        'redirect' => env('APP_URL') . "/{$lang}/provider_callback",
//    ],
//
//    'twitter' => [
//        'client_id' => env('TWITTER_CLIENT_ID'),
//        'client_secret' => env('TWITTER_CLIENT_SECRET'),
//        'redirect' => env('APP_URL') . "/{$lang}/provider_callback",
//    ],
//
//    'instagram' => [
//        'client_id' => env('INSTAGRAM_CLIENT_ID'),
//        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
//        'redirect' => env('APP_URL') . "/{$lang}/provider_callback",
//    ],


];
