<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontroler

use App\Models\Avatar; // Importuje model Avatar
use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky

class AvatarsController extends Controller // Kontroler pro práci s avatary
{
    /**
     * Metoda all vrátí všechny záznamy z tabulky avatars.
     * Používá metodu all() modelu Avatar, která získá všechna data z databáze.
     * 
     * @return \Illuminate\Database\Eloquent\Collection Seznam všech avatarů
     */
    public function all() {
        return Avatar::all(); // Získá a vrátí všechny avatary
    }
}
