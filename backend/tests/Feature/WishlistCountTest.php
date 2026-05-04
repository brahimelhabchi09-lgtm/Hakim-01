<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistCountTest extends TestCase
{
    use RefreshDatabase;

    public function test_wishlist_count_endpoint()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/wishlist/count');
        $response->assertOk()->assertJsonStructure(['count']);
    }
}
