<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommandeConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(protected Commande $commande) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order #{$this->commande->numero} confirmed")
            ->line('Your order has been confirmed.')
            ->line("Total: {$this->commande->total}")
            ->action('View Order', url("/orders/{$this->commande->id}"));
    }

    public function toArray($notifiable): array
    {
        return [
            'commande_id' => $this->commande->id,
            'numero' => $this->commande->numero,
            'message' => 'Your order has been confirmed',
        ];
    }
}
