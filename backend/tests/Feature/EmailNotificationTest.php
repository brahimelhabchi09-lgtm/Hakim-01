<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_email_sent_on_registration()
    {
        Notification::fake();
        $response = $this->postJson('/api/register', [
            'nom' => 'John', 'prenom' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        Notification::assertSentTo(User::first(), \App\Notifications\WelcomeNotification::class);
    }
}
