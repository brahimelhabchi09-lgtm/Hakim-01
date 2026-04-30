<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LigneCommandeResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'produit' => $this->whenLoaded('produit', fn() => [
                'id' => $this->produit->id,
                'nom' => $this->produit->nom,
                'image_principale' => $this->produit->image_principale ? asset('storage/' . $this->produit->image_principale) : null,
            ]),
            'produit_id' => $this->produit_id,
            'quantite' => $this->quantite,
            'prix_unitaire' => $this->prix_unitaire,
            'sous_total' => $this->sous_total,
        ];
    }
}
