<?php

namespace App\Models; // Definuje jmenný prostor pro modely aplikace

use Illuminate\Database\Eloquent\Factories\HasFactory; // Použití továrny pro generování dat
use Illuminate\Database\Eloquent\Model; // Základní třída modelu Eloquent

/**
 * Model Quiz reprezentuje kvízy v aplikaci.
 */
class Quiz extends Model
{
    use HasFactory; // Použití továrny pro generování kvízů

    /**
     * Určuje, které atributy lze hromadně přiřazovat (mass assignment).
     *
     * @var array
     */
    protected $fillable = [
        'title',       // Název kvízu
        'description', // Popis kvízu
    ];

    /**
     * Definuje vztah "jedna k mnoha" mezi kvízem a otázkami.
     * Každý kvíz má mnoho otázek.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class); // Každý kvíz má mnoho otázek
    }
}
