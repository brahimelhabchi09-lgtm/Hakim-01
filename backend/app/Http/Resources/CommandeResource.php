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
            'mode_paiement' => $this->mode_paiement,
            'statut_paiement' => $this->statut_paiement,
            'statut_paiement_label' => $this->statut_paiement_label,
            'transaction_id' => $this->transaction_id,
            'montant_paye' => $this->montant_paye,
            'date_paiement' => $this->date_paiement,
            'adresse_livraison' => $this->adresse_livraison,
            'adresse_facturation' => $this->adresse_facturation,
            'notes' => $this->notes,
            'user' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'nom' => $this->user->nom,
                'prenom' => $this->user->prenom,
                'email' => $this->user->email,
            ]),
            'items' => $this->whenLoaded('ligneCommandes', fn() => LigneCommandeResource::collection($this->ligneCommandes)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
