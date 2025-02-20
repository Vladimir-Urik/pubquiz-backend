<?php

namespace App\Models; // Definuje jmenný prostor pro modely aplikace

use Illuminate\Database\Eloquent\Factories\HasFactory; // Použití továrny pro generování dat
use Illuminate\Database\Eloquent\Model; // Základní třída modelu Eloquent

/**
 * Model QuizCompletion reprezentuje dokončení kvízu uživatelem.
 */
class QuizCompletion extends Model
{
    use HasFactory; // Použití továrny pro generování záznamů o dokončení kvízů

    /**
     * Určuje, které atributy lze hromadně přiřazovat (mass assignment).
     *
     * @var array
     */
    protected $fillable = [
        'user_id',    // ID uživatele, který dokončil kvíz
        'quiz_id',    // ID kvízu, který byl dokončen
        'score',      // Skóre získané v kvízu
        'xp_earned',  // Získané XP (zkušenostní body) za dokončení kvízu
        'answers'     // Odpovědi, které uživatel odeslal (uložené jako pole)
    ];

    /**
     * Určuje, jakým způsobem se má hodnotit sloupec 'answers'.
     * Tento sloupec je typu 'array', což znamená, že bude uložen jako pole v databázi.
     *
     * @var array
     */
    protected $casts = [
        'answers' => 'array', // Přetypování sloupce 'answers' na pole
    ];

    /**
     * Definuje vztah "mnoho k jedné" mezi dokončením kvízu a uživatelem.
     * Každé dokončení kvízu patří jednomu uživateli.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Každé dokončení kvízu patří jednomu uživateli
    }

    /**
     * Definuje vztah "mnoho k jedné" mezi dokončením kvízu a kvízem.
     * Každé dokončení kvízu patří jednomu kvízu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class); // Každé dokončení kvízu patří jednomu kvízu
    }
}
