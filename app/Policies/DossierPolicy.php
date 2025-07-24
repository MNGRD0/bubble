<?php

namespace App\Policies;

use App\Models\Dossier;
use App\Models\User;

class DossierPolicy
{
    /**
     * L'utilisateur peut voir ses propres dossiers
     */
    public function view(User $user, Dossier $dossier): bool
    {
        return $user->id === $dossier->user_id;
    }

    /**
     * L'utilisateur peut modifier ses propres dossiers
     */
    public function update(User $user, Dossier $dossier): bool
    {
        return $user->id === $dossier->user_id;
    }

    /**
     * L'utilisateur peut supprimer ses propres dossiers
     */
    public function delete(User $user, Dossier $dossier): bool
    {
        return $user->id === $dossier->user_id;
    }

    /**
     * L'utilisateur peut créer un dossier (toujours autorisé)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * (optionnel) On empêche l'accès global
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function restore(User $user, Dossier $dossier): bool
    {
        return $user->id === $dossier->user_id;
    }

    public function forceDelete(User $user, Dossier $dossier): bool
    {
        return $user->id === $dossier->user_id;
    }
}
