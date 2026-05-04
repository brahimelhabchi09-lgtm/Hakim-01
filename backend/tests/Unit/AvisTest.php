<?php

namespace Tests\Unit;

use App\Models\Avis;
use App\Models\Produit;
use App\Models\User;
use Tests\TestCase;

class AvisTest extends TestCase
{
    public function test_avis_belongs_to_produit()
    {
        $produit = Produit::factory()->create();
        $avis = Avis::factory()->for($produit)->create();
        $this->assertEquals($produit->id, $avis->produit_id);
    }

    public function test_avis_belongs_to_user()
    {
        $user = User::factory()->create();
        $avis = Avis::factory()->for($user)->create();
        $this->assertEquals($user->id, $avis->user_id);
    }

    public function test_avis_scope_approved()
    {
        Avis::factory()->create(['approuve' => true]);
        Avis::factory()->create(['approuve' => false]);
        Avis::factory()->create(['approuve' => true]);
        $this->assertEquals(2, Avis::approved()->count());
    }

    public function test_avis_average_rating()
    {
        $produit = Produit::factory()->create();
        Avis::factory()->for($produit)->create(['note' => 5]);
        Avis::factory()->for($produit)->create(['note' => 3]);
        Avis::factory()->for($produit)->create(['note' => 4]);
        $this->assertEqualsWithDelta(4.0, $produit->avis()->approved()->avg('note'), 0.01);
    }
}
