<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_order_history()
    {
        $user = User::factory()->create();
        Commande::factory()->count(3)->for($user)->create();
        $response = $this->actingAs($user)->getJson('/api/commandes');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_user_cannot_view_other_user_orders()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $commande = Commande::factory()->for($user2)->create();
        $response = $this->actingAs($user1)->getJson("/api/commandes/{$commande->id}");
        $response->assertForbidden();
    }
}
