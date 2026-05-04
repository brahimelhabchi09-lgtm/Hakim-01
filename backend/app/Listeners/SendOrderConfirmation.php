<?php

namespace App\Listeners;

use App\Events\CommandeCreated;
use App\Notifications\CommandeConfirmationNotification;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmation
{
    public function handle(CommandeCreated $event): void
    {
        $event->commande->user->notify(
            new CommandeConfirmationNotification($event->commande)
        );
    }
}
