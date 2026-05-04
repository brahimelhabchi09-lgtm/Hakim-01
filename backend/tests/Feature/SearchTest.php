<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_matching_products()
    {
        Produit::factory()->create(['nom' => 'Wireless Mouse', 'statut' => 'actif']);
        Produit::factory()->create(['nom' => 'USB Cable', 'statut' => 'actif']);
        $response = $this->getJson('/api/produits?search=wireless');
        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_search_is_case_insensitive()
    {
        Produit::factory()->create(['nom' => 'Premium Headphones', 'statut' => 'actif']);
        $response = $this->getJson('/api/produits?search=PREMIUM');
        $response->assertOk()->assertJsonCount(1, 'data');
    }
}
