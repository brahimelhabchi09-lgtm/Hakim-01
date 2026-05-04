<?php

namespace Database\Factories;

use App\Models\Marque;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MarqueFactory extends Factory
{
    protected $model = Marque::class;

    public function definition(): array
    {
        $nom = fake()->company();
        return [
            'nom' => $nom,
            'slug' => Str::slug($nom),
            'description' => fake()->paragraph(),
        ];
    }
}
