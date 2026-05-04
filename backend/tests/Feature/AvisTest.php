<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvisTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_review()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/avis', [
            'produit_id' => $produit->id,
            'note' => 5,
            'commentaire' => 'Excellent product!',
        ]);
        $response->assertCreated();
    }
}
