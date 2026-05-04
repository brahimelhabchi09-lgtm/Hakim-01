<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaiementResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'commande_id' => $this->commande_id,
            'mode_paiement' => $this->mode_paiement,
            'montant' => $this->montant,
            'statut' => $this->statut,
            'transaction_id' => $this->transaction_id,
            'payment_gateway' => $this->payment_gateway,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
