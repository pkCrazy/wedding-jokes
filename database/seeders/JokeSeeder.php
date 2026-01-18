<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Joke::factory()->count(10)->create();
    }
}
