<?php

namespace Tests\Unit;

use App\Models\Produit;
use App\Models\Category;
use App\Models\Marque;
use App\Models\Origin;
use App\Models\Tag;
use Tests\TestCase;

class ProduitTest extends TestCase
{
    public function test_produit_belongs_to_category()
    {
        $category = Category::factory()->create();
        $produit = Produit::factory()->for($category)->create();
        $this->assertInstanceOf(Category::class, $produit->category);
        $this->assertEquals($category->id, $produit->category_id);
    }

    public function test_produit_belongs_to_marque()
    {
        $marque = Marque::factory()->create();
        $produit = Produit::factory()->for($marque)->create();
        $this->assertInstanceOf(Marque::class, $produit->marque);
    }

    public function test_produit_belongs_to_origin()
    {
        $origin = Origin::factory()->create();
        $produit = Produit::factory()->for($origin)->create();
        $this->assertInstanceOf(Origin::class, $produit->origin);
    }

    public function test_produit_has_many_tags()
    {
        $produit = Produit::factory()->create();
        $produit->tags()->createMany([['name' => 'tag1'], ['name' => 'tag2']]);
        $this->assertCount(2, $produit->tags);
    }

    public function test_produit_has_many_avis()
    {
        $produit = Produit::factory()->create();
        $produit->avis()->createMany([
            ['note' => 5, 'commentaire' => 'Great'],
            ['note' => 4, 'commentaire' => 'Good'],
        ]);
        $this->assertCount(2, $produit->avis);
    }

    public function test_produit_scope_available()
    {
        Produit::factory()->create(['statut' => 'actif']);
        Produit::factory()->create(['statut' => 'inactif']);
        $this->assertEquals(1, Produit::available()->count());
    }

    public function test_produit_get_discount_percent()
    {
        $produit = Produit::factory()->create(['prix' => 100, 'prix_promo' => 75]);
        $this->assertEquals(25, $produit->discount_percent);
    }

    public function test_produit_get_is_on_sale()
    {
        $onSale = Produit::factory()->create(['prix_promo' => 50]);
        $notOnSale = Produit::factory()->create(['prix_promo' => null]);
        $this->assertTrue($onSale->is_on_sale);
        $this->assertFalse($notOnSale->is_on_sale);
    }
}
