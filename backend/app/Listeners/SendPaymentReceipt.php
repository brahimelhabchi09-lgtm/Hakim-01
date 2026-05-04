<?php

namespace App\Listeners;

use App\Events\PaiementReceived;
use Illuminate\Support\Facades\Mail;

class SendPaymentReceipt
{
    public function handle(PaiementReceived $event): void
    {
        $event->paiement->commande->user->notify(
            new \App\Notifications\PaiementConfirmationNotification($event->paiement)
        );
    }
}
