<?php

return [
    'pools' => [
        'users' => [
            // Model that will be mentioned.
            'model' => Xetaravel\Models\User::class,

            // The column that will be used to search the model.
            'column' => 'username',

            // The route used to generate the user link.
            'route' => '/users/profile/@',

            // Notification class to use when this model is mentioned.
            'notification' => Xetaravel\Notifications\MentionNotification::class,
        ]
    ],
    'regex' => '/\B((?<!(\[|\/))@[A-Za-z0-9]{4,20}+\b(?!#))/'
];
