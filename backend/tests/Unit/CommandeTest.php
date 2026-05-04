<?php

namespace Tests\Unit;

use App\Models\Commande;
use App\Models\User;
use App\Models\LigneCommande;
use App\Models\Paiement;
use Tests\TestCase;

class CommandeTest extends TestCase
{
    public function test_commande_belongs_to_user()
    {
        $user = User::factory()->create();
        $commande = Commande::factory()->for($user)->create();
        $this->assertInstanceOf(User::class, $commande->user);
    }

    public function test_commande_has_many_lignes()
    {
        $commande = Commande::factory()->create();
        $commande->lignes()->createMany([
            ['quantite' => 2, 'prix_unitaire' => 50],
            ['quantite' => 1, 'prix_unitaire' => 100],
        ]);
        $this->assertCount(2, $commande->lignes);
    }

    public function test_commande_has_one_paiement()
    {
        $commande = Commande::factory()->create();
        $commande->paiement()->create(['montant' => 200, 'methode' => 'stripe']);
        $this->assertInstanceOf(Paiement::class, $commande->paiement);
    }

    public function test_commande_scope_by_status()
    {
        Commande::factory()->create(['statut' => 'en_cours']);
        Commande::factory()->create(['statut' => 'livree']);
        Commande::factory()->create(['statut' => 'en_cours']);
        $this->assertEquals(2, Commande::byStatus('en_cours')->count());
    }

    public function test_commande_generate_numero()
    {
        $commande = Commande::factory()->create();
        $this->assertMatchesRegularExpression('/^CMD-\d{6}$/', $commande->numero);
    }
}
