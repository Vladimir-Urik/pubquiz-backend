<?php

use Illuminate\Database\Migrations\Migration; // Importuje třídu pro migrace v Laravelu
use Illuminate\Database\Schema\Blueprint; // Importuje třídu pro definování struktury tabulek
use Illuminate\Support\Facades\Schema; // Importuje třídu pro práci se schématy databáze

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tato metoda se spustí při aplikaci migrace a vytvoří tabulku.
     */
    public function up(): void
    {
        // Vytvoření tabulky 'quizzes' pro uložení informací o kvízech
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id(); // Primární klíč (auto-increment ID)
            $table->string('title'); // Název kvízu
            $table->text('description')->nullable(); // Popis kvízu, může být null
            $table->timestamps(); // Automaticky přidá sloupce 'created_at' a 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulku.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes'); // Smaže tabulku 'quizzes', pokud existuje
    }
};
