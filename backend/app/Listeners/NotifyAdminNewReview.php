<?php

namespace App\Listeners;

use App\Events\AvisSubmitted;
use App\Models\User;

class NotifyAdminNewReview
{
    public function handle(AvisSubmitted $event): void
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(
                new \App\Notifications\NewReviewNotification($event->avis)
            );
        }
    }
}
