<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    public function handle(UserRegistered $event): void
    {
        $event->user->notify(
            new \App\Notifications\WelcomeNotification()
        );
    }
}
