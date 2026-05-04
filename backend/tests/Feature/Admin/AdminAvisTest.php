<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Avis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAvisTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_reviews()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Avis::factory()->count(3)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/avis');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_admin_can_approve_review()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $avis = Avis::factory()->create(['approuve' => false]);
        $response = $this->actingAs($admin)->patchJson("/api/admin/avis/{$avis->id}/approve");
        $response->assertOk();
    }
}
