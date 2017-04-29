<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    $username = $faker->unique()->firstName;
    
    return [
        'username' => $username,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'is_admin' => 0,
        'register_ip' => $faker->ipv4,
        'last_login_ip' => $faker->ipv4
    ];
});

$factory->state(App\Models\User::class, 'isAdmin', function (Faker\Generator $faker) {
    return [
        'is_admin' => 1,
    ];
});
