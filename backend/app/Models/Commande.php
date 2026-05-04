<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Commande extends Model
{
    protected $fillable = [
        'num_commande', 'user_id', 'statut', 'total',
        'frais_livraison', 'adresse_livraison', 'adresse_facturation', 'notes',
        'mode_paiement', 'statut_paiement', 'transaction_id', 'montant_paye',
        'date_paiement', 'payment_gateway_response',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'frais_livraison' => 'decimal:2',
        'montant_paye' => 'decimal:2',
        'adresse_livraison' => 'array',
        'adresse_facturation' => 'array',
        'payment_gateway_response' => 'array',
        'date_paiement' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($commande) {
            if (empty($commande->num_commande)) {
                $commande->num_commande = 'MB-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ligneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'expediee' => 'Expédiée',
            'livree' => 'Livrée',
            'annulee' => 'Annulée',
            default => $this->statut,
        };
    }

    public function getStatutPaiementLabelAttribute(): string
    {
        return match($this->statut_paiement) {
            'en_attente' => 'En attente',
            'payee' => 'Payée',
            'echec' => 'Échec',
            'rembourse' => 'Remboursée',
            default => $this->statut_paiement ?? 'En attente',
        };
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}
