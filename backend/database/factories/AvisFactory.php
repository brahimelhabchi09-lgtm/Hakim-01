<?php

namespace Database\Factories;

use App\Models\Avis;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvisFactory extends Factory
{
    protected $model = Avis::class;

    public function definition(): array
    {
        return [
            'produit_id' => Produit::factory(),
            'user_id' => User::factory(),
            'note' => fake()->numberBetween(1, 5),
            'commentaire' => fake()->paragraph(),
            'approuve' => fake()->boolean(0.8),
        ];
    }
}
