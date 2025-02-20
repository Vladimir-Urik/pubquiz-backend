<?php

namespace App\Models; // Definuje jmenný prostor pro modely aplikace

use Illuminate\Database\Eloquent\Factories\HasFactory; // Použití továrny pro generování dat
use Illuminate\Database\Eloquent\Model; // Základní třída modelu Eloquent

/**
 * Model Answer reprezentuje odpověď na otázku v kvízu.
 */
class Answer extends Model
{
    use HasFactory; // Umožňuje použití továrny pro generování odpovědí

    /**
     * Určuje, které atributy lze hromadně přiřazovat (mass assignment).
     *
     * @var array
     */
    protected $fillable = [
        'question_id', // ID otázky, ke které odpověď patří
        'text',        // Text odpovědi
        'is_correct',  // Určuje, zda je odpověď správná (boolean)
    ];

    /**
     * Definuje vztah "mnoho k jedné" mezi odpověďmi a otázkou.
     * Každá odpověď patří k jedné otázce.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class); // Každá odpověď patří jedné otázce
    }
}
