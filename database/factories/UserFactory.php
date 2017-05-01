<?php

$factory->define(Xetaravel\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    $username = $faker->unique()->firstName;
    
    return [
        'username' => $username,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'register_ip' => $faker->ipv4,
        'last_login_ip' => $faker->ipv4
    ];
});
