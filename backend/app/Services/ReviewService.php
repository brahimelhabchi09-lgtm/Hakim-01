<?php

namespace App\Services;

use App\Models\Avis;
use App\Models\Produit;

class ReviewService
{
    public function submitReview(Produit $produit, $user, array $data): Avis
    {
        return $produit->avis()->create([
            'user_id' => $user->id,
            'note' => $data['note'],
            'commentaire' => $data['commentaire'],
            'approuve' => false,
        ]);
    }

    public function approveAvis(Avis $avis): void
    {
        $avis->update(['approuve' => true]);
    }

    public function rejectAvis(Avis $avis): void
    {
        $avis->delete();
    }

    public function getAverageRating(Produit $produit): float
    {
        return (float) round($produit->avis()->approved()->avg('note') ?? 0, 1);
    }
}
