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
        // Vytvoření tabulky "users"
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primární klíč typu auto increment
            $table->string('name'); // Sloupec pro jméno uživatele
            $table->string('email')->unique(); // Sloupec pro e-mail, musí být unikátní
            $table->timestamp('email_verified_at')->nullable(); // Sloupec pro datum a čas ověření e-mailu
            $table->string('password'); // Sloupec pro heslo
            $table->rememberToken(); // Sloupec pro token pro zapamatování přihlášení
            $table->timestamps(); // Sloupce pro časové razítka created_at a updated_at
        });

        // Vytvoření tabulky "password_reset_tokens"
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Primární klíč pro e-mailovou adresu
            $table->string('token'); // Sloupec pro token pro reset hesla
            $table->timestamp('created_at')->nullable(); // Sloupec pro čas vytvoření tokenu
        });

        // Vytvoření tabulky "sessions"
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Primární klíč pro ID session
            $table->foreignId('user_id')->nullable()->index(); // Cizí klíč na ID uživatele (pokud existuje), který je indexován
            $table->string('ip_address', 45)->nullable(); // Sloupec pro IP adresu uživatele
            $table->text('user_agent')->nullable(); // Sloupec pro User-Agent (informace o prohlížeči uživatele)
            $table->longText('payload'); // Sloupec pro payload (data relace)
            $table->integer('last_activity')->index(); // Sloupec pro poslední aktivitu s indexem
        });
    }

    /**
     * Reverse the migrations.
     * Tato metoda se spustí při rollbacku migrace a smaže tabulky.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Smaže tabulku 'users', pokud existuje
        Schema::dropIfExists('password_reset_tokens'); // Smaže tabulku 'password_reset_tokens', pokud existuje
        Schema::dropIfExists('sessions'); // Smaže tabulku 'sessions', pokud existuje
    }
};
