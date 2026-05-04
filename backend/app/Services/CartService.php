<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Support\Collection;

class CartService
{
    public function addItem(array $cart, int $produitId, int $quantite = 1): array
    {
        $produit = Produit::findOrFail($produitId);
        $key = 'produit_' . $produitId;

        if (isset($cart[$key])) {
            $cart[$key]['quantite'] += $quantite;
        } else {
            $cart[$key] = [
                'produit_id' => $produitId,
                'nom' => $produit->nom,
                'prix' => $produit->prix_actif,
                'image' => $produit->image,
                'quantite' => $quantite,
            ];
        }

        return $cart;
    }

    public function updateItem(array $cart, int $produitId, int $quantite): array
    {
        $key = 'produit_' . $produitId;
        if (isset($cart[$key])) {
            if ($quantite <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantite'] = $quantite;
            }
        }
        return $cart;
    }

    public function removeItem(array $cart, int $produitId): array
    {
        $key = 'produit_' . $produitId;
        unset($cart[$key]);
        return $cart;
    }

    public function clear(): array
    {
        return [];
    }

    public function calculateTotals(array $cart): array
    {
        $total = 0;
        $items = collect($cart)->map(function ($item) use (&$total) {
            $subtotal = $item['prix'] * $item['quantite'];
            $total += $subtotal;
            return array_merge($item, ['subtotal' => $subtotal]);
        });

        return [
            'items' => $items,
            'total' => round($total, 2),
            'count' => $items->count(),
        ];
    }
}
