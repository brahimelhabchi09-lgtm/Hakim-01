<?php

namespace Database\Factories;

use App\Models\Origin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OriginFactory extends Factory
{
    protected $model = Origin::class;

    public function definition(): array
    {
        $nom = fake()->country();
        return [
            'nom' => $nom,
            'slug' => Str::slug($nom),
        ];
    }
}
