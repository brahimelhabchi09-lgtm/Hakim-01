<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_returns_stats()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Produit::factory()->count(10)->create();
        Commande::factory()->count(5)->create(['total' => 100]);
        $response = $this->actingAs($admin)->getJson('/api/admin/dashboard');
        $response->assertOk()->assertJsonStructure([
            'total_revenue', 'total_commandes', 'total_produits', 'total_clients',
        ]);
    }
}
