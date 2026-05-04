<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_payment_for_commande()
    {
        $user = User::factory()->create();
        $commande = Commande::factory()->for($user)->create();
        $response = $this->actingAs($user)->postJson("/api/commandes/{$commande->id}/pay", [
            'methode' => 'stripe',
            'token' => 'tok_test',
        ]);
        $response->assertOk();
    }

    public function test_payment_creates_paiement_record()
    {
        $user = User::factory()->create();
        $commande = Commande::factory()->for($user)->create(['total' => 100]);
        $this->actingAs($user)->postJson("/api/commandes/{$commande->id}/pay", [
            'methode' => 'stripe',
            'token' => 'tok_test',
        ]);
        $this->assertDatabaseHas('paiements', ['commande_id' => $commande->id, 'montant' => 100]);
    }
}
