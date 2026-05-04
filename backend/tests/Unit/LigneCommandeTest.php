<?php

namespace Tests\Unit;

use App\Models\LigneCommande;
use App\Models\Commande;
use App\Models\Produit;
use Tests\TestCase;

class LigneCommandeTest extends TestCase
{
    public function test_ligne_commande_total()
    {
        $ligne = LigneCommande::factory()->create(['quantite' => 3, 'prix_unitaire' => 25]);
        $this->assertEquals(75, $ligne->total);
    }

    public function test_ligne_commande_belongs_to_commande()
    {
        $commande = Commande::factory()->create();
        $ligne = LigneCommande::factory()->for($commande)->create();
        $this->assertEquals($commande->id, $ligne->commande_id);
    }

    public function test_ligne_commande_belongs_to_produit()
    {
        $produit = Produit::factory()->create();
        $ligne = LigneCommande::factory()->for($produit)->create();
        $this->assertEquals($produit->id, $ligne->produit_id);
    }
}
