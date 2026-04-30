<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'slug' => $this->slug,
            'description' => $this->description,
            'prix' => $this->prix,
            'prix_promotionnel' => $this->prix_promotionnel,
            'stock' => $this->stock,
            'image' => $this->image,
            'images' => $this->images ?? [],
            'pays_origine' => $this->pays_origine,
            'tags' => $this->tags ?? [],
            'avis_moyenne' => $this->avis_moyenne,
            'avis_total' => $this->avis_total,
            'en_vedette' => $this->en_vedette,
            'en_promotion' => $this->en_promotion,
            'reduction_percentage' => $this->reduction_percentage,
            'category' => $this->whenLoaded('category', fn() => CategoryResource::make($this->category)),
            'marque' => $this->whenLoaded('marque', fn() => MarqueResource::make($this->marque)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
