<?php

namespace App\Services;

use App\Models\Produit;

class ProduitService
{
    public function search(array $filters = [])
    {
        $query = Produit::with(['category', 'marque', 'tags', 'avis'])
            ->where('statut', 'actif');

        if (!empty($filters['search'])) {
            $query->where('nom', 'ilike', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['marque_id'])) {
            $query->where('marque_id', $filters['marque_id']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('prix', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('prix', '<=', $filters['max_price']);
        }

        if (!empty($filters['sort'])) {
            match ($filters['sort']) {
                'price_asc' => $query->orderBy('prix', 'asc'),
                'price_desc' => $query->orderBy('prix', 'desc'),
                'name_asc' => $query->orderBy('nom', 'asc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                default => $query->orderBy('nom', 'asc'),
            };
        }

        return $query;
    }
}
