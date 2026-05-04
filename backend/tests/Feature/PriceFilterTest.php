<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriceFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_by_min_price()
    {
        Produit::factory()->create(['prix' => 20, 'statut' => 'actif']);
        Produit::factory()->create(['prix' => 100, 'statut' => 'actif']);
        $response = $this->getJson('/api/produits?min_price=50');
        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_filter_by_price_range()
    {
        Produit::factory()->create(['prix' => 20, 'statut' => 'actif']);
        Produit::factory()->create(['prix' => 50, 'statut' => 'actif']);
        Produit::factory()->create(['prix' => 100, 'statut' => 'actif']);
        $response = $this->getJson('/api/produits?min_price=30&max_price=80');
        $response->assertOk()->assertJsonCount(1, 'data');
    }
}
