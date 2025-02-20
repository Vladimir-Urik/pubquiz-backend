<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quiz::factory()->create([
            'title' => 'Slang',
        ]);
        Quiz::factory()->create([
            'title' => 'Celebrity',
        ]);
        Quiz::factory()->create([
            'title' => 'Anime',
        ]);
        Quiz::factory()->create([
            'title' => 'Emoji',
        ]);
    }
}
