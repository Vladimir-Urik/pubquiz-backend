<?php

namespace App\Providers; // Definuje jmenný prostor pro poskytovatele služeb aplikace

use Illuminate\Support\ServiceProvider; // Importuje třídu ServiceProvider, která je základem pro všechny poskytovatele služeb

/**
 * Třída AppServiceProvider je odpovědná za registraci a inicializaci služeb v aplikaci.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registruje všechny služby aplikace.
     * Tato metoda je volána při spouštění aplikace.
     * Zde můžete registrujte všechny služby, které vaše aplikace používá.
     */
    public function register(): void
    {
        // Místo pro registraci služeb (aktuálně prázdné)
    }

    /**
     * Inicializuje služby aplikace.
     * Tato metoda je volána po registraci všech služeb.
     * Slouží pro nastavení konfigurace a inicializaci dalších služeb.
     */
    public function boot(): void
    {
        // Místo pro inicializaci služeb (aktuálně prázdné)
    }
}
