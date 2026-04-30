<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['wishlist_id', 'produit_id'];

    protected $primaryKey = ['wishlist_id', 'produit_id'];

    public $incrementing = false;

    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
