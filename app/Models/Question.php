<?php

namespace App\Models; // Definuje jmenný prostor pro modely aplikace

use Illuminate\Database\Eloquent\Factories\HasFactory; // Použití továrny pro generování dat
use Illuminate\Database\Eloquent\Model; // Základní třída modelu Eloquent

/**
 * Model Question reprezentuje otázky v kvízech.
 */
class Question extends Model
{
    use HasFactory; // Použití továrny pro generování otázek

    /**
     * Určuje, které atributy lze hromadně přiřazovat (mass assignment).
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',    // ID kvízu, ke kterému otázka patří
        'text',       // Text otázky
        'content_type', // Typ obsahu (text, video, obrázek)
        'content',    // Samotný obsah (např. text otázky nebo odkaz na video)
    ];

    /**
     * Definuje vztah "mnoho k jedné" mezi otázkami a kvízem.
     * Každá otázka patří jednomu kvízu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class); // Každá otázka patří jednomu kvízu
    }

    /**
     * Definuje vztah "jedna k mnoha" mezi otázkami a odpověďmi.
     * Každá otázka může mít mnoho odpovědí.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class); // Každá otázka má mnoho odpovědí
    }
}
