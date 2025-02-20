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
        // Vytvoření tabulky 'questions' pro uložení otázek kvízů
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // Primární klíč (auto-increment ID)
            
            // Vztah k tabulce 'quizzes'
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // Cizí klíč, který odkazuje na kvíz (tabulka 'quizzes')
            // 'constrained()' automaticky použije název tabulky 'quizzes' a její primární klíč 'id'
            // 'onDelete('cascade')' znamená, že při smazání kvízu budou automaticky smazány i všechny otázky spojené s tímto kvízem
            
            $table->string('text')->nullable(); // Text otázky, může být prázdný (nullable)
            $table->string('content_type')->nullable(); // Typ obsahu otázky (např. text, obrázek, video), může být prázdný
            $table->text('content')->nullable(); // Obsah otázky, může obsahovat například text nebo HTML, může být prázdný

            $table->timestamps(); // Automatické sloupce 'created_at' a 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulku.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions'); // Smaže tabulku 'questions', pokud existuje
    }
};
