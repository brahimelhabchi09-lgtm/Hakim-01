<?php

namespace Tests\Feature;

use App\Models\Produit;
use App\Models\Category;
use App\Models\Marque;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProduitApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_produits()
    {
        Produit::factory()->count(5)->create(['statut' => 'actif']);
        $response = $this->getJson('/api/produits');
        $response->assertOk()->assertJsonCount(5, 'data');
    }

    public function test_show_produit_by_slug()
    {
        $produit = Produit::factory()->create(['slug' => 'test-product', 'statut' => 'actif']);
        $response = $this->getJson('/api/produits/test-product');
        $response->assertOk()->assertJsonPath('data.slug', 'test-product');
    }

    public function test_filter_produits_by_category()
    {
        $category = Category::factory()->create();
        Produit::factory()->count(3)->for($category)->create();
        Produit::factory()->count(2)->create();
        $response = $this->getJson("/api/produits?category_id={$category->id}");
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_filter_produits_by_marque()
    {
        $marque = Marque::factory()->create();
        Produit::factory()->count(4)->for($marque)->create();
        $response = $this->getJson("/api/produits?marque_id={$marque->id}");
        $response->assertOk()->assertJsonCount(4, 'data');
    }

    public function test_search_produits()
    {
        Produit::factory()->create(['nom' => 'Wireless Mouse', 'statut' => 'actif']);
        Produit::factory()->create(['nom' => 'USB Keyboard', 'statut' => 'actif']);
        $response = $this->getJson('/api/produits?search=wireless');
        $response->assertOk()->assertJsonCount(1, 'data');
    }
}
