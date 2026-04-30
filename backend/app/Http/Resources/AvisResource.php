<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvisResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'note' => $this->note,
            'titre' => $this->titre,
            'contenu' => $this->contenu,
            'statut' => $this->statut,
            'statut_label' => $this->statut_label,
            'user' => [
                'id' => $this->user->id,
                'nom' => $this->user->prenom . ' ' . $this->user->nom,
            ],
            'produit_id' => $this->produit_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
