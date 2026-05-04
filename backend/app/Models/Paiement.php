<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'commande_id',
        'mode_paiement',
        'montant',
        'statut',
        'transaction_id',
        'payment_gateway',
        'gateway_response',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'gateway_response' => 'array',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
