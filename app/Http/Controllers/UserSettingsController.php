<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontrolery aplikace

use App\Models\Avatar; // Importuje model Avatar pro práci s avatary
use App\Models\User; // Importuje model User pro práci s uživateli
use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky
use Illuminate\Support\Facades\Auth; // Importuje Auth pro ověřování přihlášeného uživatele

/**
 * UserSettingsController umožňuje uživatelům aktualizovat své nastavení,
 * zobrazit dostupné avatary a zobrazit žebříček uživatelů podle úrovně.
 */
class UserSettingsController extends Controller
{
    /**
     * Aktualizuje uživatelské nastavení (jméno a avatar).
     *
     * @param  \Illuminate\Http\Request  $request  HTTP požadavek s aktualizovanými údaji
     * @return \Illuminate\Http\JsonResponse JSON odpověď s potvrzením
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Získá aktuálně přihlášeného uživatele

        // Pokud je v požadavku nové jméno, provede validaci a aktualizaci
        if ($request->has('name')) {
            $request->validate([
                'name' => 'required|string|max:255', // Jméno je povinné a může mít max. 255 znaků
            ]);
            $user->name = $request->name; // Nastaví nové jméno
        }

        // Pokud je v požadavku nový avatar, provede validaci a aktualizaci
        if ($request->has('avatar_id')) {
            $request->validate([
                'avatar_id' => 'required|exists:avatars,id', // Avatar musí existovat v tabulce avatars
            ]);
            $avatar = Avatar::find($request->avatar_id); // Najde avatar podle ID
            $user->avatar = $avatar->path; // Uloží cestu k novému avataru
        }

        $user->save(); // Uloží změny do databáze

        return response()->json(['message' => 'User updated successfully.']); // Vrátí potvrzení
    }

    /**
     * Získá seznam dostupných avatarů a aktuální avatar uživatele.
     *
     * @return \Illuminate\Http\JsonResponse JSON odpověď s avatary a aktuálním avatarem
     */
    public function getAvatars()
    {
        $user = Auth::user(); // Získá aktuálního uživatele
        $avatars = Avatar::all(); // Načte všechny dostupné avatary

        return response()->json([
            'avatars' => $avatars, // Seznam avatarů
            'current_avatar' => $user->avatar, // Aktuální avatar přihlášeného uživatele
        ]);
    }

    /**
     * Získá žebříček uživatelů seřazený podle úrovně (level).
     *
     * @return \Illuminate\Http\JsonResponse JSON odpověď s uživateli v žebříčku
     */
    public function leaderboard()
    {
        $users = User::orderBy('level', 'desc')->get(); // Seřadí uživatele sestupně podle úrovně

        return response()->json($users); // Vrátí seznam uživatelů
    }
}
