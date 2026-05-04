<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagination_returns_meta()
    {
        Produit::factory()->count(25)->create(['statut' => 'actif']);
        $response = $this->getJson('/api/produits?per_page=10');
        $response->assertOk()->assertJsonStructure([
            'data', 'meta' => ['current_page', 'last_page', 'total'],
        ]);
    }
}
