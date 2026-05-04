<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $nom = fake()->word();
        return [
            'nom' => $nom,
            'slug' => Str::slug($nom),
            'description' => fake()->sentence(),
            'parent_id' => null,
        ];
    }
}
