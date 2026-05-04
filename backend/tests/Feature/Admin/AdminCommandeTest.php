<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCommandeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_all_commandes()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Commande::factory()->count(5)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/commandes');
        $response->assertOk()->assertJsonCount(5, 'data');
    }

    public function test_admin_can_update_commande_statut()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $commande = Commande::factory()->create(['statut' => 'en_cours']);
        $response = $this->actingAs($admin)->patchJson("/api/admin/commandes/{$commande->id}/statut", [
            'statut' => 'expediee',
        ]);
        $response->assertOk();
        $this->assertDatabaseHas('commandes', ['id' => $commande->id, 'statut' => 'expediee']);
    }
}
