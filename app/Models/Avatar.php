<?php

namespace App\Models; // Definuje jmenný prostor pro modely aplikace

use Illuminate\Database\Eloquent\Factories\HasFactory; // Umožňuje použití továrny pro generování dat
use Illuminate\Database\Eloquent\Model; // Základní třída modelu Eloquent

/**
 * Model Avatar reprezentuje avatary uživatelů v aplikaci.
 */
class Avatar extends Model
{
    use HasFactory; // Použití továrny pro generování avatarů

    /**
     * Určuje, které atributy lze hromadně přiřazovat (mass assignment).
     *
     * @var array
     */
    protected $fillable = [
        'name',   // Název avatara
        'path',   // Cesta k obrázku avatara
        'gender', // Pohlaví avatara (pokud je relevantní)
    ];
}
