<?php

use Illuminate\Database\Migrations\Migration; // Importuje třídu pro migrace v Laravelu
use Illuminate\Database\Schema\Blueprint; // Importuje třídu pro definování struktury tabulek
use Illuminate\Support\Facades\Schema; // Importuje třídu pro práci se schématy databáze

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tato metoda se spustí při aplikaci migrace a přidá nový sloupec 'xp' do tabulky 'users'.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('xp')->default(0); // Přidání sloupce 'xp' pro zkušenostní body, výchozí hodnota je 0
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a odstraní sloupec 'xp'.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('xp'); // Smazání sloupce 'xp'
        });
    }
};
