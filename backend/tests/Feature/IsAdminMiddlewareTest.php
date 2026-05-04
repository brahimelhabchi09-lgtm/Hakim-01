<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_routes()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->getJson('/api/admin/dashboard');
        $this->assertNotEquals(403, $response->status());
    }

    public function test_regular_user_blocked_from_admin_routes()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($user)->getJson('/api/admin/dashboard');
        $response->assertForbidden();
    }

    public function test_unauthenticated_blocked_from_admin_routes()
    {
        $response = $this->getJson('/api/admin/dashboard');
        $response->assertUnauthorized();
    }
}
