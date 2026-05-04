<?php

namespace Database\Factories;

use App\Models\LigneCommande;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class LigneCommandeFactory extends Factory
{
    protected $model = LigneCommande::class;

    public function definition(): array
    {
        $produit = Produit::factory()->create();
        return [
            'commande_id' => Commande::factory(),
            'produit_id' => $produit->id,
            'quantite' => fake()->numberBetween(1, 5),
            'prix_unitaire' => $produit->prix,
        ];
    }
}
