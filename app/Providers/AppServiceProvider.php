<?php

namespace App\Providers;



use Carbon\Carbon;
use Illuminate\Support\Facades\App;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Carbon::setLocale('fr'); // Carbon en français
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // Pour strftime si tu l’utilises
}

}
