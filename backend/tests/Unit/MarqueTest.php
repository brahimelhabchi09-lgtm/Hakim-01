<?php

namespace Tests\Unit;

use App\Models\Marque;
use App\Models\Produit;
use Tests\TestCase;

class MarqueTest extends TestCase
{
    public function test_marque_has_many_produits()
    {
        $marque = Marque::factory()->create();
        Produit::factory()->count(3)->for($marque)->create();
        $this->assertCount(3, $marque->produits);
    }

    public function test_marque_slug_generation()
    {
        $marque = Marque::factory()->create(['nom' => 'Test Brand']);
        $this->assertEquals('test-brand', $marque->slug);
    }
}
