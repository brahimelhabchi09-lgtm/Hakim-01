<?php

namespace App\DTOs;

class CartItemData
{
    public function __construct(
        public readonly int $produitId,
        public readonly string $nom,
        public readonly float $prix,
        public readonly int $quantite,
        public readonly ?string $image = null,
    ) {}

    public function getSubtotal(): float
    {
        return $this->prix * $this->quantite;
    }

    public function toArray(): array
    {
        return [
            'produit_id' => $this->produitId,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'quantite' => $this->quantite,
            'image' => $this->image,
            'subtotal' => $this->getSubtotal(),
        ];
    }
}
