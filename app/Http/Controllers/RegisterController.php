<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontrolery aplikace

use App\Models\User; // Importuje model User pro práci s uživateli
use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky
use Illuminate\Support\Facades\Hash; // Importuje Hash pro bezpečné ukládání hesel

/**
 * RegisterController zajišťuje registraci nových uživatelů.
 */
class RegisterController extends Controller
{
    /**
     * Zpracuje registraci nového uživatele.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP požadavek obsahující registrační údaje
     * @return \Illuminate\Http\JsonResponse JSON odpověď s přístupovým tokenem
     *
     * @throws \Illuminate\Validation\ValidationException Pokud validace selže
     */
    public function register(Request $request)
    {
        // Validace vstupních dat
        $request->validate([
            'name' => 'required|string|max:255', // Jméno je povinné a může mít max. 255 znaků
            'email' => 'required|string|email|max:255|unique:users', // Email musí být unikátní
            'password' => 'required|string|min:8', // Heslo musí mít min. 8 znaků
        ]);

        // Vytvoří nového uživatele v databázi
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Zahashuje heslo pro bezpečnost
        ]);

        // Vytvoří autentizační token pro uživatele
        $token = $user->createToken('auth_token')->plainTextToken;

        // Vrátí odpověď s přístupovým tokenem
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
