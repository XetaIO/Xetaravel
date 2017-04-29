<?php

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    $title = $faker->sentence;
    
    return [
        'title' => $title,
        'slug' => str_slug($title),
        'description' => $faker->paragraph(1),
        'article_count' => 0
    ];
});
