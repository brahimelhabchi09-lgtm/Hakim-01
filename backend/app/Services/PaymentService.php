<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function processPayment(Commande $commande, string $methode, float $montant): Paiement
    {
        return DB::transaction(function () use ($commande, $methode, $montant) {
            $paiement = Paiement::create([
                'commande_id' => $commande->id,
                'montant' => $montant,
                'methode' => $methode,
                'statut' => Paiement::STATUS_COMPLETED,
                'transaction_id' => $this->generateTransactionId(),
            ]);

            $commande->update([
                'statut_paiement' => 'payee',
                'methode_paiement' => $methode,
            ]);

            return $paiement;
        });
    }

    public function refundPaiement(Paiement $paiement): bool
    {
        return DB::transaction(function () use ($paiement) {
            $paiement->update(['statut' => Paiement::STATUS_REFUNDED]);
            $paiement->commande->update(['statut_paiement' => 'refundee']);
            return true;
        });
    }

    protected function generateTransactionId(): string
    {
        return 'TXN-' . strtoupper(bin2hex(random_bytes(8)));
    }
}
