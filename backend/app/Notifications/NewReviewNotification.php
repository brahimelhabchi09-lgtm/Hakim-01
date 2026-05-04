<?php

namespace App\Notifications;

use App\Models\Avis;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewReviewNotification extends Notification
{
    use Queueable;

    public function __construct(protected Avis $avis) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'avis_id' => $this->avis->id,
            'produit_id' => $this->avis->produit_id,
            'note' => $this->avis->note,
            'message' => 'New review submitted',
        ];
    }
}
