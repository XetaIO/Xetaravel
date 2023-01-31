<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xetaravel Site
    |--------------------------------------------------------------------------
    |
    | Here are each configuration related to Xetaravel itself. Those value are
    | used everywhere around the application.
    */
    'site' => [
        'copyright' => 'Emeric Fèvre',
        'title' => 'Welcome to Xetaravel',
        'description' => 'This website was made to try Laravel and to do my personnal website and I have decided to release it to help people starting with Laravel.',
        'github_url' => 'https://github.com/XetaIO/Xetaravel',
        'contact_email' => 'emeric@xetaravel.com',
        'analytics_tracker_code' => 'UA-224686157-1',
        'full_url' => 'https://xetaravel.com',
        'packagist_url' => 'https://repo.packagist.org/p2/xetaio/xetaravel.json',
        'packagist_cache_timeout' => 7200 // 2 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | All pagination settings used to paginate the queries.
    */
    'pagination' => [
        'blog' => [
            'article_per_page' => 10,
            'comment_per_page' => 10
        ],
        'notification' => [
            'notification_per_page' => 10
        ],
        'user' => [
            'user_per_page' => 15,
            'comments_profile_page' => 5,
            'articles_profile_page' => 5,
            'posts_profile_page' => 10
        ],
        'discuss' => [
            'conversation_per_page' => 15,
            'post_per_page' => 10
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Flood Rules
    |--------------------------------------------------------------------------
    |
    | All flood rules that apply at various point on the site. They are all in seconds.
    */
    'flood' => [
       'general' => 30,
       'blog' => [
           'comment' => 30
        ],
        'discuss' => [
            'conversation' => 60
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Blog
    |--------------------------------------------------------------------------
    |
    | All blog settings.
     */
    'blog' => [
        'categories_sidebar' => 25,
        'articles_sidebar' => 5
    ],

    /*
    |--------------------------------------------------------------------------
    | Discuss
    |--------------------------------------------------------------------------
    |
    |
    */
    'discuss' => [
        'categories_sidebar' => 15,
        // The number in days.
        'info_message_old_conversation' => 92
    ]
];
