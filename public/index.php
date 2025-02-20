<?php

use Illuminate\Http\Request; // Importuje třídu Request pro zpracování HTTP požadavků

define('LARAVEL_START', microtime(true)); // Definuje konstantu LARAVEL_START pro měření času spuštění aplikace

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance; // Pokud existuje soubor 'maintenance.php', aplikace přechází do režimu údržby.
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php'; // Načítá autoloader od Composeru pro všechny závislosti Laravelu a dalších balíčků

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php') // Načítá Laravel aplikaci a její konfiguraci
    ->handleRequest(Request::capture()); // Zpracovává HTTP požadavek pomocí metody 'handleRequest'
