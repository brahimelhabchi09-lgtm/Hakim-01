<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Origin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOriginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_origins()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Origin::factory()->count(3)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/origins');
        $response->assertOk();
    }
}
