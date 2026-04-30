<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MarqueResource;
use App\Http\Resources\ProduitResource;
use App\Models\Marque;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function index(): JsonResponse
    {
        $marques = Marque::withCount('produits')->get();

        return response()->json([
            'marques' => MarqueResource::collection($marques),
        ]);
    }

    public function show(string $slug, Request $request): JsonResponse
    {
        $marque = Marque::where('slug', $slug)->first();

        if (!$marque) {
            return response()->json([
                'message' => 'Marque non trouvee.',
            ], 404);
        }

        $produits = Produit::with(['category', 'marque'])
            ->where('actif', true)
            ->where('marque_id', $marque->id)
            ->latest()
            ->paginate($request->get('per_page', 12));

        return response()->json([
            'marque' => MarqueResource::make($marque),
            'produits' => ProduitResource::collection($produits),
        ]);
    }
}
