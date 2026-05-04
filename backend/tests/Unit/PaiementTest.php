<?php

namespace Tests\Unit;

use App\Models\Paiement;
use App\Models\Commande;
use Tests\TestCase;

class PaiementTest extends TestCase
{
    public function test_paiement_belongs_to_commande()
    {
        $commande = Commande::factory()->create();
        $paiement = Paiement::factory()->for($commande)->create();
        $this->assertInstanceOf(Commande::class, $paiement->commande);
    }

    public function test_paiement_status_constants()
    {
        $this->assertEquals('pending', Paiement::STATUS_PENDING);
        $this->assertEquals('completed', Paiement::STATUS_COMPLETED);
        $this->assertEquals('failed', Paiement::STATUS_FAILED);
    }

    public function test_paiement_scope_by_status()
    {
        $commande = Commande::factory()->create();
        Paiement::factory()->for($commande)->create(['statut' => 'completed']);
        Paiement::factory()->for($commande)->create(['statut' => 'pending']);
        $this->assertEquals(1, Paiement::byStatus('completed')->count());
    }
}
