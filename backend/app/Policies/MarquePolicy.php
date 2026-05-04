<?php

namespace App\Policies;

use App\Models\Marque;
use App\Models\User;

class MarquePolicy
{
    public function viewAny(User $user): bool { return true; }
    public function create(User $user): bool { return $user->is_admin; }
    public function update(User $user, Marque $marque): bool { return $user->is_admin; }
    public function delete(User $user, Marque $marque): bool { return $user->is_admin; }
}
