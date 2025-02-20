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
        // Vytvoření tabulky "jobs"
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Primární klíč (auto-increment ID)
            $table->string('queue')->index(); // Sloupec pro název fronty, která obsahuje úlohu (indexováno pro rychlejší vyhledávání)
            $table->longText('payload'); // Sloupec pro uložení datové náplně úlohy
            $table->unsignedTinyInteger('attempts'); // Počet pokusů o provedení úlohy
            $table->unsignedInteger('reserved_at')->nullable(); // Čas, kdy byla úloha vyhrazena pro zpracování
            $table->unsignedInteger('available_at'); // Čas, kdy je úloha dostupná pro zpracování
            $table->unsignedInteger('created_at'); // Čas vytvoření úlohy
        });

        // Vytvoření tabulky "job_batches"
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // Primární klíč pro identifikaci dávky úloh
            $table->string('name'); // Název dávky
            $table->integer('total_jobs'); // Celkový počet úloh v dávce
            $table->integer('pending_jobs'); // Počet úloh, které čekají na zpracování
            $table->integer('failed_jobs'); // Počet neúspěšných úloh v dávce
            $table->longText('failed_job_ids'); // Identifikátory neúspěšných úloh
            $table->mediumText('options')->nullable(); // Volitelné možnosti pro dávku úloh
            $table->integer('cancelled_at')->nullable(); // Čas, kdy byla dávka zrušena
            $table->integer('created_at'); // Čas vytvoření dávky
            $table->integer('finished_at')->nullable(); // Čas dokončení dávky
        });

        // Vytvoření tabulky "failed_jobs"
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // Primární klíč
            $table->string('uuid')->unique(); // Unikátní identifikátor pro neúspěšnou úlohu
            $table->text('connection'); // Typ připojení (např. database, redis)
            $table->text('queue'); // Fronta, do které úloha patří
            $table->longText('payload'); // Data, která byla součástí úlohy
            $table->longText('exception'); // Výjimka, která způsobila neúspěch úlohy
            $table->timestamp('failed_at')->useCurrent(); // Čas, kdy úloha selhala (automaticky nastaveno na aktuální čas)
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulky.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs'); // Smaže tabulku 'jobs', pokud existuje
        Schema::dropIfExists('job_batches'); // Smaže tabulku 'job_batches', pokud existuje
        Schema::dropIfExists('failed_jobs'); // Smaže tabulku 'failed_jobs', pokud existuje
    }
};
