<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'produit' => new ProduitResource($this->whenLoaded('produit')),
            'created_at' => $this->created_at,
        ];
    }
}
