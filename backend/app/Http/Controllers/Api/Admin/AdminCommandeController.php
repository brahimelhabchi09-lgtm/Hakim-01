<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminCommandeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Commande::with('user')->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $query->where('num_commande', 'like', "%{$request->search}%");
        }

        return response()->json(CommandeResource::collection($query->paginate($request->get('per_page', 15))));
    }

    public function show($id): JsonResponse
    {
        $commande = Commande::with(['ligneCommandes.produit', 'user'])->findOrFail($id);

        return response()->json([
            'commande' => CommandeResource::make($commande),
        ]);
    }

    public function updateStatut(Request $request, $id): JsonResponse
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,expediee,livree,annulee',
        ]);

        $commande = Commande::findOrFail($id);
        $commande->update(['statut' => $request->statut]);

        return response()->json([
            'message' => 'Statut de la commande mis a jour.',
            'commande' => CommandeResource::make($commande),
        ]);
    }
}
