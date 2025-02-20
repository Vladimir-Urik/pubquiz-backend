<?php

namespace Database\Seeders;

use App\Models\User; // Importuje model User pro vytváření uživatelů
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder; // Importuje základní třídu Seeder, která je základ pro všechny seedery


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); 
        
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); // Vytváří konkrétního uživatele se jménem 'Test User' a e-mailem 'test@example.com'
    }
}

