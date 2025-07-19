<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Recette;
use App\Policies\RecettePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Recette::class => RecettePolicy::class,
    ];

    public function boot(): void
    {
        // Pas besoin d’ajouter manuellement Gate ici
    }
}
