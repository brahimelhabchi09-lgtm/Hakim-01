<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_to_cart()
    {
        $produit = Produit::factory()->create(['stock' => 10]);
        $response = $this->postJson('/api/panier', ['produit_id' => $produit->id, 'quantite' => 1]);
        $response->assertOk();
    }
}
