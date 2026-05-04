<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/user/profile');
        $response->assertOk()->assertJsonStructure(['data' => ['id', 'nom', 'prenom', 'email']]);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/user/profile', [
            'nom' => 'Updated',
            'prenom' => 'Name',
            'telephone' => '+212600000000',
        ]);
        $response->assertOk();
    }
}
