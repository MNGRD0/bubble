<?php

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;

class JournalPolicy
{
    public function update(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function view(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function delete(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }
}
