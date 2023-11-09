<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create a new Faker instance
        $faker = \Faker\Factory::create();

        // 2. Generate a few articles
        for ($i = 0; $i < 100; $i++) {
            $createdDate = $faker->dateTimeBetween('-1 years', 'now');
            $title = $faker->sentence;
            DB::table('articles')->insert([
                'title' => $title,
                'image' => "https://picsum.photos/640/480?random=" . mt_rand(1, 55000),
                'content' => $faker->sentence(100),
                'slug' => Str::slug($title),
                'creator_id' => 1,
                'created_at' => $createdDate,
                'updated_at' => $createdDate,
                'publish_date' => $createdDate,
            ]);
        }
    } 
}
