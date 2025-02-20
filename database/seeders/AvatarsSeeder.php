<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avatars = [
            [
                "name" => "Billie Eilish",
                "path" => "billie.webp",
                "gender" => "female"
            ],
            [
                "name" => "Duklock",
                "path" => "duklock.webp",
                "gender" => "male"
            ],
            [
                "name" => "MenT",
                "path" => "ment.webp",
                "gender" => "male"
            ],
            [
                "name" => "Ice Spice",
                "path" => "icespice.webp",
                "gender" => "female"
            ],
            [
                "name" => "iShowSpeed",
                "path" => "ishowspeed.webp",
                "gender" => "male",
            ],
            [
                "name" => "kazma",
                "path" => "kazma.webp",
                "gender" => "male",
            ],
            [
                "name" => "Sugar Denny",
                "path" => "sugardenny.webp",
                "gender" => "female"
            ]
        ];

        Avatar::factory()->createMany($avatars);
    }
}
