<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_returns_all_stats()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Produit::factory()->count(5)->create();
        Commande::factory()->count(3)->create(['total' => 100]);
        $response = $this->actingAs($admin)->getJson('/api/admin/dashboard');
        $response->assertOk()->assertJsonStructure([
            'total_revenue', 'total_commandes', 'total_produits', 'total_clients',
        ]);
    }
}
