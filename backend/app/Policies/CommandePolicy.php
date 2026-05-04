<?php

namespace App\Policies;

use App\Models\Commande;
use App\Models\User;

class CommandePolicy
{
    public function view(User $user, Commande $commande): bool
    {
        return $user->is_admin || $user->id === $commande->user_id;
    }

    public function updateStatus(User $user, Commande $commande): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Commande $commande): bool
    {
        return $user->is_admin;
    }
}
