<?php

namespace App\Observers;

use App\Models\Produit;
use App\Events\ProduitOutOfStock;
use Illuminate\Support\Str;

class ProduitObserver
{
    public function creating(Produit $produit): void
    {
        if (!$produit->slug) {
            $produit->slug = Str::slug($produit->nom);
        }
    }

    public function updating(Produit $produit): void
    {
        if ($produit->isDirty('stock') && $produit->stock <= 0) {
            ProduitOutOfStock::dispatch($produit);
        }
    }
}
