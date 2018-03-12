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
        'description' => 'You will find content related to web development like tutorials, my personal tests on new technologies etc',
        'github_url' => 'https://github.com/XetaIO/Xetaravel',
        'contact_email' => 'contact@xeta.io',
        'analytics_tracker_code' => 'UA-40328289-2',
        'full_url' => 'https://xetaravel.xeta.io',
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
            'comments_profile_page' => 20,
            'articles_profile_page' => 15
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
        'categories_sidebar' => 2, //15,
        // The number in days.
        'info_message_old_conversation' => 92
    ]
];
