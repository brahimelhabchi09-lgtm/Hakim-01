<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_toggle_wishlist()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/wishlist/toggle', ['produit_id' => $produit->id]);
        $response->assertOk();
    }

    public function test_get_wishlist()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/wishlist');
        $response->assertOk()->assertJsonStructure(['items']);
    }
}
