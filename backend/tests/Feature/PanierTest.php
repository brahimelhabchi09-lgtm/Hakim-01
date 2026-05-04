<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanierTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);
        $response = $this->actingAs($user)->postJson('/api/panier', [
            'produit_id' => $produit->id,
            'quantite' => 2,
        ]);
        $response->assertOk();
    }

    public function test_update_cart_item()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);
        $this->actingAs($user)->postJson('/api/panier', ['produit_id' => $produit->id, 'quantite' => 2]);
        $response = $this->actingAs($user)->putJson("/api/panier/{$produit->id}", ['quantite' => 5]);
        $response->assertOk();
    }

    public function test_remove_from_cart()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);
        $this->actingAs($user)->postJson('/api/panier', ['produit_id' => $produit->id, 'quantite' => 1]);
        $response = $this->actingAs($user)->deleteJson("/api/panier/{$produit->id}");
        $response->assertOk();
    }

    public function test_get_cart()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/panier');
        $response->assertOk()->assertJsonStructure(['items', 'total']);
    }

    public function test_clear_cart()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);
        $this->actingAs($user)->postJson('/api/panier', ['produit_id' => $produit->id, 'quantite' => 1]);
        $response = $this->actingAs($user)->deleteJson('/api/panier/clear');
        $response->assertOk();
    }
}
