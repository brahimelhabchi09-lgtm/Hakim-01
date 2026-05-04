<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_notifications()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/notifications');
        $response->assertOk()->assertJsonStructure(['data']);
    }

    public function test_user_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        $notification = $user->notifications()->create([
            'type' => 'test',
            'data' => ['message' => 'Test'],
        ]);
        $response = $this->actingAs($user)->postJson("/api/notifications/{$notification->id}/read");
        $response->assertOk();
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();
        $user->notifications()->create(['type' => 'test', 'data' => ['message' => 'Test']]);
        $response = $this->actingAs($user)->postJson('/api/notifications/read-all');
        $response->assertOk();
    }

    public function test_user_can_delete_notification()
    {
        $user = User::factory()->create();
        $notification = $user->notifications()->create([
            'type' => 'test',
            'data' => ['message' => 'Test'],
        ]);
        $response = $this->actingAs($user)->deleteJson("/api/notifications/{$notification->id}");
        $response->assertOk();
    }
}
