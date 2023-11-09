<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        // 1. Call the ArticleSeeder
        $this->call(ArticleSeeder::class);
        // 2. Call the UserSeeder
        $this->call(UserSeeder::class);
    }
}
