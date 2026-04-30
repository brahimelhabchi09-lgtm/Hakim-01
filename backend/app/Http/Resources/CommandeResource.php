<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'num_commande' => $this->num_commande,
            'statut' => $this->statut,
            'statut_label' => $this->statut_label,
            'total' => $this->total,
            'frais_livraison' => $this->frais_livraison,
            'adresse_livraison' => $this->adresse_livraison,
            'adresse_facturation' => $this->adresse_facturation,
            'notes' => $this->notes,
            'items' => $this->whenLoaded('ligneCommandes', fn() => LigneCommandeResource::collection($this->ligneCommandes)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
