<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory; // Importuje třídu Factory pro generování testovacích dat
use Illuminate\Support\Facades\Hash; // Importuje třídu Hash pro hashování hesel
use Illuminate\Support\Str; // Importuje třídu Str pro práci s řetězci

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     * Statická proměnná pro uchovávání hesla používaného v továrně.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     * Metoda, která definuje výchozí stav modelu pro generování falešných dat.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // Generuje náhodné jméno
            'email' => fake()->unique()->safeEmail(), // Generuje unikátní e-mailovou adresu
            'email_verified_at' => now(), // Nastaví aktuální čas pro ověření e-mailu
            'password' => static::$password ??= Hash::make('password'), // Nastaví heslo, pokud není nastavena statická proměnná, použije se výchozí 'password'
            'remember_token' => Str::random(10), // Generuje náhodný token pro "zapamatování" uživatele
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     * Tato metoda určuje, že e-mailová adresa uživatele by měla být neověřená.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // Nastaví hodnotu `email_verified_at` na `null` pro neověřený e-mail
        ]);
    }
}
