<?php

namespace App\Models; // Definuje jmenný prostor pro modely aplikace

use Illuminate\Database\Eloquent\Factories\HasFactory; // Použití továrny pro generování dat
use Illuminate\Foundation\Auth\User as Authenticatable; // Umožňuje autentifikaci uživatele
use Illuminate\Notifications\Notifiable; // Povolení notifikací pro uživatele
use Laravel\Sanctum\HasApiTokens; // Umožňuje použití API tokenů pomocí Sanctum

/**
 * Model User reprezentuje uživatele v aplikaci.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens; // Použití vlastností pro továrny, notifikace a API tokeny

    /**
     * Atributy, které lze hromadně přiřazovat (mass assignment).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',     // Jméno uživatele
        'email',    // E-mailová adresa uživatele
        'password', // Heslo uživatele
        'avatar',   // Cesta k avataru uživatele
    ];

    /**
     * Atributy, které budou přidány k serializovanému modelu.
     * Tato funkce přidává level na základě XP.
     *
     * @var list<string>
     */
    protected $appends = ['level'];

    /**
     * Atributy, které by měly být skryté při serializaci modelu.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',       // Heslo uživatele, které bude skryté při serializaci
        'remember_token', // Token pro zapamatování přihlášení
    ];

    /**
     * Definuje, jaké atributy budou přetypovány (casted) při serializaci.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Přetypování na datetime pro ověření e-mailu
            'password' => 'hashed',            // Heslo bude uložené jako hash
        ];
    }

    /**
     * Spočítá úroveň uživatele na základě XP.
     * Používá jednoduchý vzorec, kde se úroveň počítá z XP: floor(sqrt(XP / 100)).
     *
     * @return int
     */
    public function getLevelAttribute(): int
    {
        return (int) floor(sqrt($this->xp / 100)); // Výpočet úrovně na základě XP
    }
}
