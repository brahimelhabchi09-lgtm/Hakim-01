<?php

namespace App\Rules;

use App\Models\Produit;
use Illuminate\Contracts\Validation\Rule;

class EnoughStock implements Rule
{
    protected Produit $produit;

    public function __construct(int $produitId)
    {
        $this->produit = Produit::findOrFail($produitId);
    }

    public function passes($attribute, $value): bool
    {
        return $this->produit->stock >= $value;
    }

    public function message(): string
    {
        return "Only {$this->produit->stock} items available for {$this->produit->nom}.";
    }
}
