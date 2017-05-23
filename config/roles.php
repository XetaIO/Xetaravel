<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Here you can change the slug separator. This is very important in matter
    | of magic method __call() and also a `Slugable` trait. The default value
    | is a dot.
    |
    */

    'separator' => '.',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you want, you can replace default models from this package by models
    | you created. Have a look at `Ultraware\Roles\Models\Role` model and
    | `Ultraware\Roles\Models\Permission` model.
    |
    */

    'models' => [
        'role' => Xetaravel\Models\Role::class,
        'permission' => Xetaravel\Models\Permission::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles, Permissions and Allowed "Pretend"
    |--------------------------------------------------------------------------
    |
    | You can pretend or simulate package behavior no matter what is in your
    | database. It is really useful when you are testing you application.
    | Set up what will methods hasRole(), hasPermission() and allowed() return.
    |
    */

    'pretend' => [

        'enabled' => false,

        'options' => [
            'hasRole' => true,
            'hasPermission' => true,
            'allowed' => true,
        ],

    ],

];
