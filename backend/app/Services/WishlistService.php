<?php

namespace App\Services;

use App\Models\Wishlist;
use App\Models\Produit;

class WishlistService
{
    public function toggle(Wishlist $wishlist, Produit $produit): bool
    {
        $existing = $wishlist->items()->where('produit_id', $produit->id)->first();
        if ($existing) {
            $existing->delete();
            return false;
        }
        $wishlist->items()->create(['produit_id' => $produit->id]);
        return true;
    }

    public function isInWishlist(Wishlist $wishlist, int $produitId): bool
    {
        return $wishlist->items()->where('produit_id', $produitId)->exists();
    }
}
