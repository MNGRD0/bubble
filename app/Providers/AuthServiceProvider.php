<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Recette;
use App\Policies\RecettePolicy;
use App\Models\Journal;
use App\Policies\JournalPolicy;



class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Recette::class => RecettePolicy::class,
        \App\Models\Journal::class => \App\Policies\JournalPolicy::class,
        Dossier::class => DossierPolicy::class,
        Dessin::class => DessinPolicy::class,
    ];
    

    public function boot(): void
    {
        // Pas besoin d’ajouter manuellement Gate ici
    }
}
