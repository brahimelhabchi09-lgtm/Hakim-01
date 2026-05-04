<?php

namespace App\Listeners;

use App\Events\CommandeStatusUpdated;

class SendStatusUpdateNotification
{
    public function handle(CommandeStatusUpdated $event): void
    {
        $event->commande->user->notify(
            new \App\Notifications\CommandeStatutUpdatedNotification($event->commande)
        );
    }
}
