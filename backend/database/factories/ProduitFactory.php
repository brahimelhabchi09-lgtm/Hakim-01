<?php

namespace Database\Factories;

use App\Models\Produit;
use App\Models\Category;
use App\Models\Marque;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        $nom = fake()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'marque_id' => Marque::factory(),
            'nom' => $nom,
            'slug' => Str::slug($nom),
            'description' => fake()->paragraph(),
            'prix' => fake()->randomFloat(2, 10, 500),
            'prix_promo' => null,
            'stock' => fake()->numberBetween(0, 100),
            'statut' => 'actif',
        ];
    }

    public function onSale(): static
    {
        return $this->state(['prix_promo' => fn(array $attrs) => $attrs['prix'] * 0.75]);
    }

    public function outOfStock(): static
    {
        return $this->state(['stock' => 0]);
    }
}
