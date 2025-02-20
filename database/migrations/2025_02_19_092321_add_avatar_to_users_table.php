<?php

use Illuminate\Database\Migrations\Migration; // Importuje třídu pro migrace v Laravelu
use Illuminate\Database\Schema\Blueprint; // Importuje třídu pro definování struktury tabulek
use Illuminate\Support\Facades\Schema; // Importuje třídu pro práci se schématy databáze

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tato metoda se spustí při aplikaci migrace a přidá cizí klíč do tabulky 'users'.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Přidává sloupec 'avatar', který je cizí klíč na tabulku 'avatars'
            $table->foreignId('avatar')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a odstraní cizí klíč a sloupec 'avatar'.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Odstraňuje cizí klíč a sloupec 'avatar'
            $table->dropForeign(['avatar']);
            $table->dropColumn('avatar');
        });
    }
};
