<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProduitResource;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);

        return response()->json([
            'items' => $this->formatCartItems($cart),
            'total' => $this->calculateTotal($cart),
            'count' => $this->countItems($cart),
        ]);
    }

    public function ajouter(Request $request): JsonResponse
    {
        $request->validate([
            'produit_id' => 'required|integer|exists:produits,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        if ($produit->stock < $request->quantite) {
            return response()->json([
                'message' => 'Stock insuffisant.',
            ], 400);
        }

        $cart = $this->getCart($request);
        $rowId = $produit->id;

        if (isset($cart[$rowId])) {
            $newQty = $cart[$rowId]['quantite'] + $request->quantite;
            if ($produit->stock < $newQty) {
                return response()->json([
                    'message' => 'Stock insuffisant pour cette quantite.',
                ], 400);
            }
            $cart[$rowId]['quantite'] = $newQty;
        } else {
            $cart[$rowId] = [
                'produit_id' => $produit->id,
                'quantite' => $request->quantite,
            ];
        }

        $this->saveCart($request, $cart);

        return response()->json([
            'message' => 'Produit ajoute au panier.',
            'items' => $this->formatCartItems($cart),
            'total' => $this->calculateTotal($cart),
            'count' => $this->countItems($cart),
        ]);
    }

    public function update(Request $request, string $rowId): JsonResponse
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart($request);

        if (!isset($cart[$rowId])) {
            return response()->json([
                'message' => 'Article non trouve dans le panier.',
            ], 404);
        }

        $produit = Produit::findOrFail($rowId);

        if ($produit->stock < $request->quantite) {
            return response()->json([
                'message' => 'Stock insuffisant.',
            ], 400);
        }

        $cart[$rowId]['quantite'] = $request->quantite;
        $this->saveCart($request, $cart);

        return response()->json([
            'message' => 'Quantite modifiee.',
            'items' => $this->formatCartItems($cart),
            'total' => $this->calculateTotal($cart),
            'count' => $this->countItems($cart),
        ]);
    }

    public function destroy(Request $request, string $rowId): JsonResponse
    {
        $cart = $this->getCart($request);

        if (!isset($cart[$rowId])) {
            return response()->json([
                'message' => 'Article non trouve dans le panier.',
            ], 404);
        }

        unset($cart[$rowId]);
        $this->saveCart($request, $cart);

        return response()->json([
            'message' => 'Article supprime du panier.',
            'items' => $this->formatCartItems($cart),
            'total' => $this->calculateTotal($cart),
            'count' => $this->countItems($cart),
        ]);
    }

    public function vider(Request $request): JsonResponse
    {
        $this->saveCart($request, []);

        return response()->json([
            'message' => 'Panier vide.',
            'items' => [],
            'total' => 0,
            'count' => 0,
        ]);
    }

    private function getCart(Request $request): array
    {
        if ($request->user()) {
            return session()->get('cart_' . $request->user()->id, []);
        }

        return session()->get('cart_guest_' . session()->getId(), []);
    }

    private function saveCart(Request $request, array $cart): void
    {
        if ($request->user()) {
            session()->put('cart_' . $request->user()->id, $cart);
        } else {
            session()->put('cart_guest_' . session()->getId(), $cart);
        }
    }

    private function formatCartItems(array $cart): array
    {
        $items = [];
        foreach ($cart as $rowId => $item) {
            $produit = Produit::with(['category', 'marque'])->find($rowId);
            if ($produit) {
                $items[] = [
                    'row_id' => $rowId,
                    'produit' => ProduitResource::make($produit),
                    'quantite' => $item['quantite'],
                    'sous_total' => $this->getProduitPrice($produit) * $item['quantite'],
                ];
            }
        }
        return $items;
    }

    private function calculateTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $rowId => $item) {
            $produit = Produit::find($rowId);
            if ($produit) {
                $total += $this->getProduitPrice($produit) * $item['quantite'];
            }
        }
        return round($total, 2);
    }

    private function countItems(array $cart): int
    {
        return array_sum(array_column($cart, 'quantite'));
    }

    private function getProduitPrice(Produit $produit): float
    {
        return $produit->prix_promotionnel ?? $produit->prix;
    }
}
