<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProduitResource;
use App\Models\Produit;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => $request->user()->id]);

        $produits = $wishlist->produits()->with(['category', 'marque'])->get();

        return response()->json([
            'produits' => ProduitResource::collection($produits),
            'count' => $produits->count(),
        ]);
    }

    public function ajouter(Request $request): JsonResponse
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
        ]);

        $user = $request->user();
        $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

        $exists = WishlistItem::where('wishlist_id', $wishlist->id)
            ->where('produit_id', $request->produit_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Produit deja dans la wishlist.',
            ], 400);
        }

        WishlistItem::create([
            'wishlist_id' => $wishlist->id,
            'produit_id' => $request->produit_id,
        ]);

        return response()->json([
            'message' => 'Produit ajoute aux favoris.',
        ], 201);
    }

    public function destroy(Request $request, $produitId): JsonResponse
    {
        $wishlist = Wishlist::where('user_id', $request->user()->id)->first();

        if (!$wishlist) {
            return response()->json([
                'message' => 'Wishlist non trouvee.',
            ], 404);
        }

        WishlistItem::where('wishlist_id', $wishlist->id)
            ->where('produit_id', $produitId)
            ->delete();

        return response()->json([
            'message' => 'Produit retire des favoris.',
        ]);
    }
}
