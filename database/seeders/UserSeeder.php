<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
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
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('123456'),
                'role' => $faker->randomElement(['admin', 'moderator', 'creator', 'user']),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
