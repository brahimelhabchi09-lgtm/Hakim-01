<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $commandes = $request->user()
            ->commandes()
            ->withCount('ligneCommandes')
            ->latest()
            ->paginate($request->get('per_page', 10));

        return response()->json(CommandeResource::collection($commandes));
    }

    public function show($id, Request $request): JsonResponse
    {
        $commande = $request->user()
            ->commandes()
            ->with(['ligneCommandes.produit'])
            ->findOrFail($id);

        return response()->json([
            'commande' => CommandeResource::make($commande),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'adresse_livraison' => 'required|array',
            'adresse_livraison.nom' => 'required|string|max:255',
            'adresse_livraison.telephone' => 'required|string|max:20',
            'adresse_livraison.adresse' => 'required|string|max:500',
            'adresse_livraison.ville' => 'required|string|max:100',
            'adresse_livraison.code_postal' => 'nullable|string|max:10',
            'adresse_facturation' => 'nullable|array',
            'notes' => 'nullable|string|max:1000',
            'mode_paiement' => 'required|in:cash',
        ]);

        $cart = session()->get('cart_' . $user->id, []);

        if (empty($cart)) {
            return response()->json([
                'message' => 'Votre panier est vide.',
            ], 400);
        }

        DB::beginTransaction();

        try {
            $fraisLivraison = $this->calculateLivraison($request->adresse_livraison['ville'] ?? '');
            $total = $fraisLivraison;
            $items = [];

            foreach ($cart as $produitId => $item) {
                $produit = Produit::lockForUpdate()->findOrFail($produitId);

                if ($produit->stock < $item['quantite']) {
                    throw new \Exception("Stock insuffisant pour {$produit->nom}.");
                }

                $price = $produit->prix_promotionnel ?? $produit->prix;
                $total += $price * $item['quantite'];

                $items[] = [
                    'produit' => $produit,
                    'quantite' => $item['quantite'],
                    'prix' => $price,
                ];
            }

            $commande = Commande::create([
                'user_id' => $user->id,
                'total' => $total - $fraisLivraison,
                'frais_livraison' => $fraisLivraison,
                'adresse_livraison' => $request->adresse_livraison,
                'adresse_facturation' => $request->adresse_facturation ?? $request->adresse_livraison,
                'notes' => $request->notes,
                'statut' => 'en_attente',
                'mode_paiement' => $request->mode_paiement,
                'statut_paiement' => 'en_attente',
            ]);

            foreach ($items as $item) {
                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $item['produit']->id,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix'],
                ]);

                $item['produit']->decrement('stock', $item['quantite']);
            }

            session()->forget('cart_' . $user->id);

            DB::commit();

            return response()->json([
                'message' => 'Commande creee avec succes.',
                'commande' => CommandeResource::make($commande->load('ligneCommandes.produit')),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function cancel($id, Request $request): JsonResponse
    {
        $commande = $request->user()->commandes()->findOrFail($id);

        if (!in_array($commande->statut, ['en_attente', 'en_cours'])) {
            return response()->json([
                'message' => 'Impossible d\'annuler cette commande.',
            ], 400);
        }

        $commande->update(['statut' => 'annulee']);

        foreach ($commande->ligneCommandes as $item) {
            $item->produit->increment('stock', $item->quantite);
        }

        return response()->json([
            'message' => 'Commande annulee.',
            'commande' => CommandeResource::make($commande),
        ]);
    }

    private function calculateLivraison(string $ville): float
    {
        $zones = [
            'casablanca' => 35,
            'rabat' => 40,
            'marrakech' => 45,
            'fes' => 50,
            'tanger' => 55,
            'agadir' => 50,
            'meknes' => 45,
            'oujda' => 60,
            'kenitra' => 40,
            'tetouan' => 55,
        ];

        return $zones[strtolower($ville)] ?? 60;
    }
}
