<?php

namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OutOfStockNotification extends Notification
{
    use Queueable;

    public function __construct(protected Produit $produit) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'produit_id' => $this->produit->id,
            'produit_nom' => $this->produit->nom,
            'message' => "Product '{$this->produit->nom}' is out of stock",
        ];
    }
}
