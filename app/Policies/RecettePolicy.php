<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Recette;

class RecettePolicy
{
    public function update(User $user, Recette $recette): bool
    {
        return $user->id === $recette->user_id;
    }

    public function delete(User $user, Recette $recette): bool
    {
        return $user->id === $recette->user_id;
    }
}
