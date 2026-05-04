<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeFactory extends Factory
{
    protected $model = Commande::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'numero' => 'CMD-' . str_pad((string) fake()->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'total' => fake()->randomFloat(2, 20, 1000),
            'statut' => fake()->randomElement(['en_cours', 'expediee', 'livree', 'annulee']),
            'adresse_livraison' => fake()->address(),
            'ville' => fake()->city(),
        ];
    }
}
