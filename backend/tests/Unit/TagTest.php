<?php

namespace Tests\Unit;

use App\Models\Tag;
use App\Models\Produit;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function test_tag_belongs_to_many_produits()
    {
        $tag = Tag::factory()->create();
        $produit1 = Produit::factory()->create();
        $produit2 = Produit::factory()->create();
        $tag->produits()->attach([$produit1->id, $produit2->id]);
        $this->assertCount(2, $tag->produits);
    }
}
