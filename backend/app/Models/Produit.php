<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Produit extends Model
{
    protected $fillable = [
        'nom', 'slug', 'description', 'prix', 'prix_promotionnel',
        'stock', 'image', 'images', 'pays_origine', 'tags',
        'avis_moyenne', 'avis_total', 'en_vedette',
        'category_id', 'marque_id',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_promotionnel' => 'decimal:2',
        'stock' => 'integer',
        'images' => 'array',
        'tags' => 'array',
        'avis_moyenne' => 'decimal:2',
        'avis_total' => 'integer',
        'en_vedette' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($produit) {
            if (empty($produit->slug)) {
                $produit->slug = Str::slug($produit->nom);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class)->where('statut', 'approuve');
    }

    public function allAvis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    public function ligneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function getEnPromotionAttribute(): bool
    {
        return $this->prix_promotionnel !== null && $this->prix_promotionnel < $this->prix;
    }

    public function getReductionPercentageAttribute(): float
    {
        if (!$this->en_promotion) {
            return 0;
        }
        return round((($this->prix - $this->prix_promotionnel) / $this->prix) * 100);
    }
}
