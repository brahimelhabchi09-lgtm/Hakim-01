<?php

namespace Tests\Unit;

use App\Models\Origin;
use App\Models\Produit;
use Tests\TestCase;

class OriginTest extends TestCase
{
    public function test_origin_has_many_produits()
    {
        $origin = Origin::factory()->create();
        Produit::factory()->count(2)->for($origin)->create();
        $this->assertCount(2, $origin->produits);
    }
}
