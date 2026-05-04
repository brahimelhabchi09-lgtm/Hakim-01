<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use App\Notifications\CommandeStatutUpdatedNotification;
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

        $perPage = $request->get('per_page', 15);
        return response()->json(CommandeResource::collection($query->paginate($perPage)));
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

        $commande = Commande::with('user')->findOrFail($id);
        $oldStatut = (string) $commande->statut;
        $newStatut = (string) $request->statut;

        if ($oldStatut === $newStatut) {
            return response()->json([
                'message' => 'Le statut de la commande est deja a jour.',
                'commande' => CommandeResource::make($commande),
            ]);
        }

        $commande->update(['statut' => $newStatut]);

        if ($commande->user) {
            $commande->user->notify(
                new CommandeStatutUpdatedNotification($commande, $oldStatut, $newStatut)
            );
        }

        return response()->json([
            'message' => 'Statut de la commande mis a jour. Notification envoyee a l utilisateur.',
            'commande' => CommandeResource::make($commande),
        ]);
    }

    public function updateStatutPaiement(Request $request, $id): JsonResponse
    {
        $request->validate([
            'statut_paiement' => 'required|in:en_attente,payee,echec,rembourse',
        ]);

        $commande = Commande::findOrFail($id);
        $commande->update(['statut_paiement' => $request->statut_paiement]);

        return response()->json([
            'message' => 'Statut de paiement mis a jour.',
            'commande' => CommandeResource::make($commande),
        ]);
    }

}
