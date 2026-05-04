<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use App\Models\Avis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_product_reviews()
    {
        $produit = Produit::factory()->create();
        Avis::factory()->count(3)->for($produit)->create(['approuve' => true]);
        $response = $this->getJson("/api/produits/{$produit->slug}/avis");
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_only_show_approved_reviews()
    {
        $produit = Produit::factory()->create();
        Avis::factory()->for($produit)->create(['approuve' => true]);
        Avis::factory()->for($produit)->create(['approuve' => false]);
        $response = $this->getJson("/api/produits/{$produit->slug}/avis");
        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_user_can_update_own_review()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $avis = Avis::factory()->for($produit)->for($user)->create();
        $response = $this->actingAs($user)->putJson("/api/avis/{$avis->id}", [
            'note' => 4,
            'commentaire' => 'Updated review',
        ]);
        $response->assertOk();
    }
}
