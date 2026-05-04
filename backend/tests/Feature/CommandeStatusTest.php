<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_transition_to_confirmed()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $commande = Commande::factory()->for($admin)->create(['statut' => 'en_cours']);
        $response = $this->actingAs($admin)->patchJson("/api/admin/commandes/{$commande->id}/statut", ['statut' => 'confirmee']);
        $response->assertOk();
    }

    public function test_admin_can_transition_to_shipped()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $commande = Commande::factory()->for($admin)->create(['statut' => 'confirmee']);
        $response = $this->actingAs($admin)->patchJson("/api/admin/commandes/{$commande->id}/statut", ['statut' => 'expediee']);
        $response->assertOk();
    }

    public function test_admin_can_transition_to_delivered()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $commande = Commande::factory()->for($admin)->create(['statut' => 'expediee']);
        $response = $this->actingAs($admin)->patchJson("/api/admin/commandes/{$commande->id}/statut", ['statut' => 'livree']);
        $response->assertOk();
    }

    public function test_admin_can_cancel_order()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $commande = Commande::factory()->for($admin)->create(['statut' => 'en_cours']);
        $response = $this->actingAs($admin)->patchJson("/api/admin/commandes/{$commande->id}/statut", ['statut' => 'annulee']);
        $response->assertOk();
    }
}
