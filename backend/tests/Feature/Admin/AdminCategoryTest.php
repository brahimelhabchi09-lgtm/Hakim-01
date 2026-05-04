<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_categories()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Category::factory()->count(3)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/categories');
        $response->assertOk();
    }

    public function test_admin_can_create_category()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->postJson('/api/admin/categories', ['nom' => 'Electronics']);
        $response->assertCreated();
    }
}
