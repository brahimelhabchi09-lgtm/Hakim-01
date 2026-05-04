<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulkOperationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_bulk_delete_products()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Produit::factory()->count(3)->create();
        $ids = Produit::pluck('id');
        $response = $this->actingAs($admin)->postJson('/api/admin/produits/bulk-delete', ['ids' => $ids]);
        $response->assertOk();
    }

    public function test_admin_can_bulk_update_status()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Produit::factory()->count(3)->create();
        $ids = Produit::pluck('id');
        $response = $this->actingAs($admin)->postJson('/api/admin/produits/bulk-status', [
            'ids' => $ids,
            'statut' => 'inactif',
        ]);
        $response->assertOk();
    }
}
