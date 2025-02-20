<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontrolery aplikace

use App\Models\User; // Importuje model User pro práci s databází uživatelů
use Illuminate\Http\JsonResponse; // Importuje JsonResponse pro návrat JSON odpovědi

/**
 * LeaderboardController slouží k získání žebříčku nejlepších hráčů podle XP.
 */
class LeaderboardController extends Controller
{
    /**
     * Vrátí žebříček 13 nejlepších uživatelů seřazených podle XP.
     *
     * @return JsonResponse JSON odpověď obsahující seznam uživatelů s nejvyšším XP
     */
    public function index(): JsonResponse
    {
        // Získá 13 uživatelů s nejvyšším XP, seřazených sestupně (nejlepší první)
        // Vybere pouze sloupce id, name, xp a avatar
        $users = User::orderBy('xp', 'desc')->take(13)->get(['id', 'name', 'xp', 'avatar']);
        
        // Vrátí data ve formátu JSON
        return response()->json($users);
    }
}
