<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_tags()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Tag::factory()->count(3)->create();
        $response = $this->actingAs($admin)->getJson('/api/admin/tags');
        $response->assertOk();
    }

    public function test_admin_can_create_tag()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->postJson('/api/admin/tags', ['nom' => 'New Tag']);
        $response->assertCreated();
    }
}
