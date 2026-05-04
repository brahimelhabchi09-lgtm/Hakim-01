<?php

namespace App\Listeners;

use App\Events\ProduitOutOfStock;
use App\Models\User;

class NotifyAdminOutOfStock
{
    public function handle(ProduitOutOfStock $event): void
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(
                new \App\Notifications\OutOfStockNotification($event->produit)
            );
        }
    }
}
