<?php

namespace Database\Factories;

use App\Models\WishlistItem;
use App\Models\Wishlist;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistItemFactory extends Factory
{
    protected $model = WishlistItem::class;

    public function definition(): array
    {
        return [
            'wishlist_id' => Wishlist::factory(),
            'produit_id' => Produit::factory(),
        ];
    }
}
