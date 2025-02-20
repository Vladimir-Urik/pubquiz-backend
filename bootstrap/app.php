<?php

use Illuminate\Foundation\Application; // Importuje třídu Application pro inicializaci aplikace
use Illuminate\Foundation\Configuration\Exceptions; // Importuje třídu pro zpracování výjimek v konfiguraci
use Illuminate\Foundation\Configuration\Middleware; // Importuje třídu pro middleware v konfiguraci

// Konfiguruje a vytváří instanci aplikace s vlastními nastaveními
return Application::configure(basePath: dirname(__DIR__)) // Nastavuje základní cestu aplikace na nadřazený adresář
    ->withRouting( // Definuje cesty pro různé typy routování
        web: __DIR__.'/../routes/web.php', // Cesta k souboru s webovými routami
        api: __DIR__.'/../routes/api.php', // Cesta k souboru s routami pro API
        commands: __DIR__.'/../routes/console.php', // Cesta k souboru s routami pro konzolové příkazy
        health: '/up', // Cesta pro health check
    )
    ->withMiddleware(function (Middleware $middleware) { // Definuje middleware pro aplikaci
    })
    ->withExceptions(function (Exceptions $exceptions) { // Definuje, jak bude aplikace zpracovávat výjimky
    })
    ->create(); // Vytváří instanci aplikace s výše uvedenými nastaveními
