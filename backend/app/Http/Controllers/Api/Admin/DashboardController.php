<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        $ventes = [
            'today' => Commande::where('statut', '!=', 'annulee')
                ->whereDate('created_at', $today)->sum('total'),
            'week' => Commande::where('statut', '!=', 'annulee')
                ->where('created_at', '>=', $weekStart)->sum('total'),
            'month' => Commande::where('statut', '!=', 'annulee')
                ->where('created_at', '>=', $monthStart)->sum('total'),
            'total' => Commande::where('statut', '!=', 'annulee')->sum('total'),
        ];

        $commandes = [
            'en_attente' => Commande::where('statut', 'en_attente')->count(),
            'en_cours' => Commande::where('statut', 'en_cours')->count(),
            'expediees' => Commande::where('statut', 'expediee')->count(),
            'livrees' => Commande::where('statut', 'livree')->count(),
            'total' => Commande::count(),
        ];

        $produits = [
            'total' => Produit::count(),
            'low_stock' => Produit::where('stock', '<=', 5)->count(),
            'rupture' => Produit::where('stock', 0)->count(),
        ];

        $avis = [
            'en_attente' => Avis::where('statut', 'en_attente')->count(),
            'approuves' => Avis::where('statut', 'approuve')->count(),
            'total' => Avis::count(),
        ];

        $recentCommandes = Commande::with('user')->latest()->limit(5)->get();
        $recentAvis = Avis::with(['user', 'produit'])->latest()->limit(5)->get();

        return response()->json([
            'ventes' => $ventes,
            'commandes' => $commandes,
            'produits' => $produits,
            'avis' => $avis,
            'recent_commandes' => $recentCommandes,
            'recent_avis' => $recentAvis,
        ]);
    }
}
