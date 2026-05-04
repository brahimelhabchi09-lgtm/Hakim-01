<?php

namespace App\DTOs;

class CheckoutData
{
    public function __construct(
        public readonly array $items,
        public readonly string $adresseLivraison,
        public readonly string $ville,
        public readonly ?string $methodePaiement = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['items'],
            $data['adresse_livraison'],
            $data['ville'],
            $data['methode_paiement'] ?? null,
        );
    }
}
