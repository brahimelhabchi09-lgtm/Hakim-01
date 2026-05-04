<?php

namespace Tests\Feature;

use Tests\TestCase;

class ValidationTest extends TestCase
{
    public function test_register_requires_all_fields()
    {
        $response = $this->postJson('/api/register', []);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['nom', 'prenom', 'email', 'password']);
    }

    public function test_register_requires_valid_email()
    {
        $response = $this->postJson('/api/register', [
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_register_passwords_must_match()
    {
        $response = $this->postJson('/api/register', [
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['password']);
    }
}
