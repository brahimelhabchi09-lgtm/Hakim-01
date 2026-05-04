<?php

namespace App\Events;

use App\Models\Avis;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AvisSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Avis $avis) {}
}
