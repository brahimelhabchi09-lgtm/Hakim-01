<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvisResource;
use App\Models\Avis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAvisController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Avis::with(['user', 'produit'])->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        return response()->json(AvisResource::collection($query->paginate($request->get('per_page', 15))));
    }

    public function approuve($id): JsonResponse
    {
        $avis = Avis::findOrFail($id);
        $avis->update(['statut' => 'approuve']);

        $this->updateProduitRating($avis->produit_id);

        return response()->json([
            'message' => 'Avis approuve.',
            'avis' => AvisResource::make($avis),
        ]);
    }

    public function rejete($id): JsonResponse
    {
        $avis = Avis::findOrFail($id);
        $avis->update(['statut' => 'rejete']);

        $this->updateProduitRating($avis->produit_id);

        return response()->json([
            'message' => 'Avis rejete.',
            'avis' => AvisResource::make($avis),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $avis = Avis::findOrFail($id);
        $produitId = $avis->produit_id;

        $avis->delete();

        $this->updateProduitRating($produitId);

        return response()->json([
            'message' => 'Avis supprime.',
        ]);
    }

    private function updateProduitRating(int $produitId): void
    {
        $produit = \App\Models\Produit::find($produitId);
        if ($produit) {
            $approuves = $produit->allAvis()->where('statut', 'approuve')->get();

            if ($approuves->count() > 0) {
                $produit->avis_moyenne = round($approuves->avg('note'), 2);
                $produit->avis_total = $approuves->count();
            } else {
                $produit->avis_moyenne = 0;
                $produit->avis_total = 0;
            }

            $produit->save();
        }
    }
}
