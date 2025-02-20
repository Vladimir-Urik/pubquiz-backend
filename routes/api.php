<?php

use App\Http\Controllers\AvatarsController; // Importuje kontroler pro avatary
use App\Http\Controllers\LoginController; // Importuje kontroler pro přihlášení
use App\Http\Controllers\RegisterController; // Importuje kontroler pro registraci
use App\Http\Controllers\UserSettingsController; // Importuje kontroler pro nastavení uživatele
use App\Http\Controllers\LeaderboardController; // Importuje kontroler pro žebříček
use App\Http\Controllers\QuizController; // Importuje kontroler pro kvízy
use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky
use Illuminate\Support\Facades\Route; // Importuje třídu Route pro definování směrování

// Skupina rout pro autentizační operace
Route::prefix("/auth")->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Skupina rout pro uživatelské operace, vyžaduje autentizaci pomocí middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->prefix("/user")->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::post('/update', [UserSettingsController::class, 'update']);
});

Route::get('/avatars', [AvatarsController::class, 'all']); // Route pro získání seznamu všech avatarů
Route::get('/leaderboard', [LeaderboardController::class, 'index']); // Route pro získání žebříčku

// Skupina rout pro operace s kvízy, vyžaduje autentizaci pomocí middleware 'auth:sanctum'
Route::prefix("/quizzes")->group(function () {
    Route::get('', [QuizController::class, 'index']);
    Route::get('/{id}/questions', [QuizController::class, 'showQuestions']);
    Route::post('/{id}/submit', [QuizController::class, 'submit']);
})->middleware('auth:sanctum');
