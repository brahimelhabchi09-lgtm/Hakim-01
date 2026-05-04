<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortTest extends TestCase
{
    use RefreshDatabase;

    public function test_sort_by_price_asc()
    {
        Produit::factory()->create(['prix' => 30, 'statut' => 'actif']);
        Produit::factory()->create(['prix' => 10, 'statut' => 'actif']);
        Produit::factory()->create(['prix' => 20, 'statut' => 'actif']);
        $response = $this->getJson('/api/produits?sort=price_asc');
        $response->assertOk();
    }

    public function test_sort_by_newest()
    {
        Produit::factory()->count(3)->create(['statut' => 'actif']);
        $response = $this->getJson('/api/produits?sort=newest');
        $response->assertOk();
    }
}
