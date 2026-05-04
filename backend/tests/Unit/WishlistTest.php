<?php

namespace Tests\Unit;

use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\User;
use App\Models\Produit;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    public function test_wishlist_belongs_to_user()
    {
        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->for($user)->create();
        $this->assertEquals($user->id, $wishlist->user_id);
    }

    public function test_wishlist_has_many_items()
    {
        $wishlist = Wishlist::factory()->create();
        WishlistItem::factory()->count(3)->for($wishlist)->create();
        $this->assertCount(3, $wishlist->items);
    }

    public function test_wishlist_toggle_item()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $wishlist = $user->wishlist()->create();
        $wishlist->items()->create(['produit_id' => $produit->id]);
        $this->assertTrue($wishlist->items()->where('produit_id', $produit->id)->exists());
    }
}
