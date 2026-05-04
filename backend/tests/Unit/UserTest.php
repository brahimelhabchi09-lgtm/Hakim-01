<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Commande;
use App\Models\Wishlist;
use App\Models\Avis;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_many_commandes()
    {
        $user = User::factory()->create();
        $user->commandes()->createMany([
            ['total' => 100, 'statut' => 'en_cours'],
            ['total' => 200, 'statut' => 'livree'],
        ]);
        $this->assertCount(2, $user->commandes);
    }

    public function test_user_has_one_wishlist()
    {
        $user = User::factory()->create();
        $wishlist = $user->wishlist()->create();
        $this->assertInstanceOf(Wishlist::class, $user->wishlist);
    }

    public function test_user_has_many_avis()
    {
        $user = User::factory()->create();
        $user->avis()->createMany([
            ['note' => 5, 'commentaire' => 'Excellent'],
            ['note' => 4, 'commentaire' => 'Bien'],
        ]);
        $this->assertCount(2, $user->avis);
    }

    public function test_user_scope_admin()
    {
        User::factory()->create(['is_admin' => true]);
        User::factory()->create(['is_admin' => false]);
        $this->assertEquals(1, User::admins()->count());
    }

    public function test_user_is_admin_accessor()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_admin' => false]);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($user->is_admin);
    }
}
