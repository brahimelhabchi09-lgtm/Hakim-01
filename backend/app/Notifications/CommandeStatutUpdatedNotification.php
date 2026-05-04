<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommandeStatutUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Commande $commande,
        protected string $oldStatut,
        protected string $newStatut
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Mise a jour de votre commande ' . $this->commande->num_commande)
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->nom ?? ''))
            ->line('Le statut de votre commande a ete mis a jour.')
            ->line('Commande: ' . $this->commande->num_commande)
            ->line('Ancien statut: ' . $this->labelForStatut($this->oldStatut))
            ->line('Nouveau statut: ' . $this->labelForStatut($this->newStatut))
            ->action('Voir ma commande', rtrim((string) config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/') . '/compte')
            ->line('Merci pour votre confiance.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'commande_id' => $this->commande->id,
            'num_commande' => $this->commande->num_commande,
            'old_statut' => $this->oldStatut,
            'new_statut' => $this->newStatut,
            'old_statut_label' => $this->labelForStatut($this->oldStatut),
            'new_statut_label' => $this->labelForStatut($this->newStatut),
            'message' => 'Votre commande ' . $this->commande->num_commande . ' est maintenant "' . $this->labelForStatut($this->newStatut) . '".',
            'url' => '/compte/commandes/' . $this->commande->id,
        ];
    }

    private function labelForStatut(string $statut): string
    {
        return match ($statut) {
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'expediee' => 'Expediee',
            'livree' => 'Livree',
            'annulee' => 'Annulee',
            default => $statut,
        };
    }
}
