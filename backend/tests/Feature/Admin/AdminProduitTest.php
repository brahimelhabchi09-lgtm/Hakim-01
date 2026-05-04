<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProduitTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_produits()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Produit::factory()->count(3)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/produits');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_admin_can_create_produit()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->postJson('/api/admin/produits', [
            'nom' => 'New Product',
            'slug' => 'new-product',
            'description' => 'A great product',
            'prix' => 99.99,
            'stock' => 50,
            'category_id' => 1,
        ]);
        $response->assertCreated();
    }

    public function test_admin_can_update_produit()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $produit = Produit::factory()->create();
        $response = $this->actingAs($admin)->putJson("/api/admin/produits/{$produit->id}", [
            'nom' => 'Updated Product',
            'prix' => 149.99,
        ]);
        $response->assertOk();
    }

    public function test_admin_can_delete_produit()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $produit = Produit::factory()->create();
        $response = $this->actingAs($admin)->deleteJson("/api/admin/produits/{$produit->id}");
        $response->assertOk();
    }
}
