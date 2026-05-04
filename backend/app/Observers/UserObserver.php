<?php

namespace App\Observers;

use App\Models\User;
use App\Events\UserRegistered;

class UserObserver
{
    public function created(User $user): void
    {
        UserRegistered::dispatch($user);
    }
}
