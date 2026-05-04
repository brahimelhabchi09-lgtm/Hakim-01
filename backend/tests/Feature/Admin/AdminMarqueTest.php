<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Marque;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMarqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_marques()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Marque::factory()->count(3)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/marques');
        $response->assertOk();
    }
}
