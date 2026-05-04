<?php

namespace Tests\Feature;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_produit_resource_format()
    {
        $category = Category::factory()->create();
        $produit = Produit::factory()->for($category)->create();
        $response = $this->getJson("/api/produits/{$produit->slug}");
        $response->assertJsonStructure([
            'data' => ['id', 'nom', 'slug', 'prix', 'description', 'stock', 'statut'],
        ]);
    }
}
