<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontrolery aplikace

use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky
use Illuminate\Support\Facades\Auth; // Importuje Auth pro ověřování uživatelů
use Illuminate\Validation\ValidationException; // Importuje výjimku pro validaci

/**
 * LoginController zajišťuje přihlašování a odhlašování uživatelů.
 */
class LoginController extends Controller
{
    /**
     * Zpracuje požadavek na přihlášení uživatele.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP požadavek obsahující přihlašovací údaje
     * @return \Illuminate\Http\JsonResponse  JSON odpověď s access tokenem
     *
     * @throws \Illuminate\Validation\ValidationException Pokud jsou přihlašovací údaje neplatné
     */
    public function login(Request $request)
    {
        // Ověří, že požadavek obsahuje platný e-mail a heslo
        $request->validate([
            'email' => 'required|email', // E-mail je povinný a musí být ve správném formátu
            'password' => 'required|string', // Heslo je povinné a musí být řetězec
        ]);

        // Pokusí se ověřit uživatele pomocí zadaného e-mailu a hesla
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Pokud přihlašovací údaje nejsou správné, vyhodí výjimku s chybovou zprávou
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Pokud je přihlášení úspěšné, získá přihlášeného uživatele
        $user = $request->user();

        // Vytvoří nový autentizační token pro uživatele
        $token = $user->createToken('auth_token')->plainTextToken;

        // Vrátí JSON odpověď s access tokenem
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer', // Standardní typ tokenu pro API autentizaci
        ]);
    }

    /**
     * Zpracuje požadavek na odhlášení uživatele.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP požadavek obsahující autentizovaného uživatele
     * @return \Illuminate\Http\JsonResponse  JSON odpověď potvrzující odhlášení
     */
    public function logout(Request $request)
    {
        // Smaže aktuální přístupový token uživatele (odhlášení)
        $request->user()->currentAccessToken()->delete();

        // Vrátí JSON odpověď potvrzující úspěšné odhlášení
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
