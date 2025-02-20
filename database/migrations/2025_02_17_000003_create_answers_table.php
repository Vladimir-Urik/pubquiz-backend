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
        // Vytvoření tabulky 'answers' pro uložení odpovědí na otázky
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // Primární klíč (auto-increment ID)
            
            // Vztah k tabulce 'questions'
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // Cizí klíč, který odkazuje na otázku (tabulka 'questions')
            // 'constrained()' automaticky použije název tabulky 'questions' a její primární klíč 'id'
            // 'onDelete('cascade')' znamená, že při smazání otázky budou automaticky smazány i všechny odpovědi spojené s touto otázkou

            $table->string('text'); // Text odpovědi
            $table->boolean('is_correct')->default(false); // Označuje, zda je odpověď správná (true/false), výchozí hodnota je 'false'
            $table->timestamps(); // Automatické sloupce 'created_at' a 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulku.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers'); // Smaže tabulku 'answers', pokud existuje
    }
};
