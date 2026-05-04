<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Models\Avis;
use Carbon\Carbon;

class DashboardService
{
    public function getStats(?Carbon $from = null, ?Carbon $to = null): array
    {
        $query = Commande::query();
        if ($from) $query->where('created_at', '>=', $from);
        if ($to) $query->where('created_at', '<=', $to);

        return [
            'total_revenue' => $query->sum('total'),
            'total_commandes' => $query->count(),
            'total_produits' => Produit::count(),
            'total_clients' => User::where('is_admin', false)->count(),
            'total_avis' => Avis::count(),
            'commandes_en_cours' => Commande::where('statut', 'en_cours')->count(),
        ];
    }

    public function getRevenueByDay(int $days = 30): array
    {
        return Commande::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getTopProduits(int $limit = 5)
    {
        return Produit::withCount('lignesCommandes')
            ->orderBy('lignes_commandes_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
