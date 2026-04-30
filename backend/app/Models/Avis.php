<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    protected $fillable = ['user_id', 'produit_id', 'note', 'titre', 'contenu', 'statut'];

    protected $casts = [
        'note' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'approuve' => 'Approuvé',
            'rejete' => 'Rejeté',
            default => $this->statut,
        };
    }
}
