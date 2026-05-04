<?php

namespace App\Notifications;

use App\Models\Paiement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaiementConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(protected Paiement $paiement) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment received')
            ->line("Payment of {$this->paiement->montant} received")
            ->line("Method: {$this->paiement->methode}")
            ->line("Transaction: {$this->paiement->transaction_id}");
    }

    public function toArray($notifiable): array
    {
        return [
            'paiement_id' => $this->paiement->id,
            'message' => 'Payment received successfully',
        ];
    }
}
