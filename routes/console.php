<?php

use Illuminate\Foundation\Inspiring; // Importuje třídu Inspiring pro získání inspirujících citátů
use Illuminate\Support\Facades\Artisan; // Importuje třídu Artisan pro definování vlastních příkazů

// Definuje nový Artisan příkaz 'inspire'
Artisan::command('inspire', function () {
    // Při zavolání příkazu 'inspire' se zobrazí inspirující citát
    $this->comment(Inspiring::quote()); // Zavolá metodu quote() třídy Inspiring pro získání citátu a vypíše ho
})->purpose('Display an inspiring quote');
