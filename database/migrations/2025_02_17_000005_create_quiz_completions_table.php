<?php

use Illuminate\Database\Migrations\Migration; // Importuje třídu pro migrace v Laravelu
use Illuminate\Database\Schema\Blueprint; // Importuje třídu pro definování struktury tabulek
use Illuminate\Support\Facades\Schema; // Importuje třídu pro práci se schématy databáze

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tato metoda se spustí při aplikaci migrace a vytvoří tabulku 'quiz_completions'.
     */
    public function up(): void
    {
        Schema::create('quiz_completions', function (Blueprint $table) {
            $table->id(); // Primární klíč pro tuto tabulku (auto-increment)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cizí klíč na uživatele
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // Cizí klíč na kvíz
            $table->integer('score'); // Skóre dosažené uživatelem v kvízu
            $table->integer('xp_earned'); // XP získané uživatelem za dokončení kvízu
            $table->json('answers'); // Odpovědi uživatele, uložené jako JSON
            $table->timestamps(); // Automaticky přidá sloupce 'created_at' a 'updated_at'

            // Nastavení jedinečného klíče pro kombinaci 'user_id' a 'quiz_id', aby každý uživatel mohl dokončit kvíz jen jednou
            $table->unique(['user_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a odstraní tabulku 'quiz_completions'.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_completions'); // Odstraní tabulku 'quiz_completions'
    }
};
