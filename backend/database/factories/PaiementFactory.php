<?php

namespace Database\Factories;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    protected $model = Paiement::class;

    public function definition(): array
    {
        $commande = Commande::factory()->create();
        return [
            'commande_id' => $commande->id,
            'montant' => $commande->total,
            'methode' => fake()->randomElement(['stripe', 'paypal', 'cod']),
            'statut' => Paiement::STATUS_COMPLETED,
            'transaction_id' => 'TXN-' . strtoupper(fake()->regexify('[A-F0-9]{16}')),
        ];
    }
}
