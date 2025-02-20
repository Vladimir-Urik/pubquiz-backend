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
        // Vytvoření tabulky "personal_access_tokens" pro uložení osobních přístupových tokenů
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // Primární klíč (auto-increment ID)
            $table->morphs('tokenable'); // Sloupec pro morfování, který umožňuje vztah k různým modelům (např. User, Admin)
            $table->string('name'); // Název tokenu (např. "API Access")
            $table->string('token', 64)->unique(); // Token (unikátní 64 znaků dlouhý)
            $table->text('abilities')->nullable(); // Schopnosti tokenu (např. oprávnění pro různé akce, může být null)
            $table->timestamp('last_used_at')->nullable(); // Čas posledního použití tokenu (může být null, pokud ještě nebyl použit)
            $table->timestamp('expires_at')->nullable(); // Čas expirace tokenu (může být null, pokud token nevyprší)
            $table->timestamps(); // Automaticky přidá sloupce "created_at" a "updated_at"
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulku.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens'); // Smaže tabulku 'personal_access_tokens', pokud existuje
    }
};
