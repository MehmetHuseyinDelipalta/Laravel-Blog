<?php

use Illuminate\Database\Eloquent\Factories\Factory;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'image' => $faker->imageUrl(),
        'content' => $faker->paragraph(3),
        'slug' => $faker->slug,
        'creator_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
        'publish_date' => now(),
    ];
});
