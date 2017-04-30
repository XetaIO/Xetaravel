<?php

$factory->define(Xetaravel\Models\Article::class, function (Faker\Generator $faker) {
    $title = $faker->sentence;
    
    return [
        'user_id' => 1,
        'category_id' => 1,
        'title' => $title,
        'slug' => str_slug($title),
        'content' => $faker->paragraph,
        'comment_count' => 0,
        'is_display' => 1
    ];
});

$factory->state(Xetaravel\Models\Article::class, 'notDisplay', function (Faker\Generator $faker) {
    return [
        'is_display' => 0,
    ];
});
