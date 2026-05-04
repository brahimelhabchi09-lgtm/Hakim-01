<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Produit;
use App\Models\Commande;
use App\Policies\ProduitPolicy;
use App\Policies\CommandePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PoliciesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_produit()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $policy = new ProduitPolicy();
        $this->assertTrue($policy->create($admin));
    }

    public function test_regular_user_cannot_create_produit()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $policy = new ProduitPolicy();
        $this->assertFalse($policy->create($user));
    }

    public function test_user_can_view_own_commande()
    {
        $user = User::factory()->create();
        $commande = Commande::factory()->for($user)->create();
        $policy = new CommandePolicy();
        $this->assertTrue($policy->view($user, $commande));
    }
}
