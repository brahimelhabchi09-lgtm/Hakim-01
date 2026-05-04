<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\User;

class AvisPolicy
{
    public function create(User $user): bool { return true; }
    public function update(User $user, Avis $avis): bool { return $user->is_admin || $user->id === $avis->user_id; }
    public function delete(User $user, Avis $avis): bool { return $user->is_admin || $user->id === $avis->user_id; }
    public function approve(User $user, Avis $avis): bool { return $user->is_admin; }
}
