<?php

use Illuminate\Database\Migrations\Migration; // Importuje třídu pro migrace v Laravelu
use Illuminate\Database\Schema\Blueprint; // Importuje třídu pro definování struktury tabulek
use Illuminate\Support\Facades\Schema; // Importuje třídu pro práci se schématy databáze

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tato metoda se spustí při aplikaci migrace a vytváří tabulky.
     */
    public function up(): void
    {
        // Vytvoření tabulky "cache"
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Sloupec pro unikátní klíč, který je primární klíč
            $table->mediumText('value'); // Sloupec pro uložené hodnoty (délka až 16 MB textu)
            $table->integer('expiration'); // Sloupec pro čas expirace v sekundách
        });

        // Vytvoření tabulky "cache_locks"
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Sloupec pro unikátní klíč, který je primární klíč
            $table->string('owner'); // Sloupec pro majitele zámku (například server nebo proces)
            $table->integer('expiration'); // Sloupec pro čas expirace zámku
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulky.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache'); // Smaže tabulku 'cache', pokud existuje
        Schema::dropIfExists('cache_locks'); // Smaže tabulku 'cache_locks', pokud existuje
    }
};
