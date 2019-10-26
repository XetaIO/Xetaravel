<?php

return [
    /**
     * Whatever to enabled or not the analytics administration.
     */
    'enabled' => env('ANALYTICS_ENABLED', false),

    /**
     * The start date used to get the browsers statistics. Should be formated as `Y-m-d`.
     */
    'start_date' => '2014-08-01',

    /*
     * The view id of which you want to display data.
     */
    'view_id' => env('ANALYTICS_VIEW_ID'),

    /*
     * Path to the client secret json file. Take a look at the README of this package
     * to learn how to get this file.
     */
    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),

    /*
     * The amount of seconds the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_secondes' => 7200,  // 2 hours

    /*
     * Here you may configure the "store" that the underlying Google_Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig (see docs for google-api-php-client).
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => env('ANALYTICS_CACHE_STORE', 'file'),
    ],
];
