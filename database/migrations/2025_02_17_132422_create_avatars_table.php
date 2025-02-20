<?php

use Illuminate\Database\Migrations\Migration; // Importuje třídu pro migrace v Laravelu
use Illuminate\Database\Schema\Blueprint; // Importuje třídu pro definování struktury tabulek
use Illuminate\Support\Facades\Schema; // Importuje třídu pro práci se schématy databáze

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tato metoda se spustí při aplikaci migrace a vytvoří tabulku 'avatars'.
     */
    public function up(): void
    {
        Schema::create('avatars', function (Blueprint $table) {
            $table->id(); // Primární klíč pro tuto tabulku (auto-increment)
            $table->string("name"); // Sloupec pro název avatare
            $table->string("path"); // Sloupec pro cestu k souboru s avatarem (URL nebo lokální cesta)
            $table->string("gender"); // Sloupec pro pohlaví avatare (např. "male", "female", "neutral")
            $table->timestamps(); // Automaticky přidá sloupce 'created_at' a 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a odstraní tabulku 'avatars'.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars'); // Odstraní tabulku 'avatars'
    }
};
