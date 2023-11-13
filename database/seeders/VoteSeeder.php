<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($vote = 0; $vote < 10000; $vote++) {
            DB::table('votes')->insert([
                'article_id' => rand(1, 100),
                'user_id' => rand(1, 10),
                'vote' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
