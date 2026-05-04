<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_commande()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['statut' => 'actif', 'stock' => 10]);
        $response = $this->actingAs($user)->postJson('/api/checkout', [
            'items' => [['produit_id' => $produit->id, 'quantite' => 1]],
            'adresse_livraison' => '123 Test St',
            'ville' => 'Casablanca',
        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('commandes', ['user_id' => $user->id]);
    }

    public function test_user_can_view_own_commandes()
    {
        $user = User::factory()->create();
        Commande::factory()->count(2)->for($user)->create();
        $response = $this->actingAs($user)->getJson('/api/commandes');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_user_can_view_commande_detail()
    {
        $user = User::factory()->create();
        $commande = Commande::factory()->for($user)->create();
        $response = $this->actingAs($user)->getJson("/api/commandes/{$commande->id}");
        $response->assertOk();
    }
}
