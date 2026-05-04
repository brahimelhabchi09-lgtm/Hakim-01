<?php

namespace App\Observers;

use App\Models\Commande;
use App\Events\CommandeCreated;
use Illuminate\Support\Facades\DB;

class CommandeObserver
{
    public function created(Commande $commande): void
    {
        CommandeCreated::dispatch($commande);
    }
}
