<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutService
{
    public function createCommande($user, array $data): Commande
    {
        return DB::transaction(function () use ($user, $data) {
            $total = 0;
            $commande = Commande::create([
                'user_id' => $user->id,
                'numero' => $this->generateNumero(),
                'total' => 0,
                'adresse_livraison' => $data['adresse_livraison'],
                'ville' => $data['ville'],
                'statut' => 'en_cours',
            ]);

            foreach ($data['items'] as $item) {
                $produit = Produit::findOrFail($item['produit_id']);
                if ($produit->stock < $item['quantite']) {
                    throw new Exception("Insufficient stock for {$produit->nom}");
                }

                $produit->decrement('stock', $item['quantite']);
                $ligneTotal = $produit->prix_actif * $item['quantite'];
                $total += $ligneTotal;

                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $produit->id,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $produit->prix_actif,
                ]);
            }

            $commande->update(['total' => $total]);
            return $commande->load('lignes.produit');
        });
    }

    protected function generateNumero(): string
    {
        return 'CMD-' . str_pad((string) Commande::count() + 1, 6, '0', STR_PAD_LEFT);
    }
}
