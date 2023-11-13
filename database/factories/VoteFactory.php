<?php

use Illuminate\Database\Eloquent\Factories\Factory;

$factory->define(App\Models\Vote::class, function (Faker $faker) {
    return [
        'article_id' => 1, // veya rastgele bir makale ID'si kullanabilirsiniz
        'user_id' => $faker->numberBetween(1, 10),
        'vote' => 5,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
