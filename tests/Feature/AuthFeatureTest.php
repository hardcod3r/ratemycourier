<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Ένας χρήστης μπορεί να συνδεθεί με έγκυρα διαπιστευτήρια.
     */
    public function test_a_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => ['token'],
                     'timestamp'
                 ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test: Ένας χρήστης ΔΕΝ μπορεί να συνδεθεί με άκυρα διαπιστευτήρια.
     */
    public function test_a_user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Unauthorized',
                 ]);

        $this->assertGuest();
    }

    /**
     * Test: Ένας συνδεδεμένος χρήστης μπορεί να αποσυνδεθεί.
     */
    public function test_a_logged_in_user_can_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Συνδέουμε τον χρήστη και παίρνουμε το token
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ], [
            'Accept' => 'application/json'
        ]);

        $token = $loginResponse->json('data.token');

        // Κάνουμε logout
        $logoutResponse = $this->postJson('/api/logout', [], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $logoutResponse->assertStatus(200)
                       ->assertJson([
                           'message' => 'Logged out successfully',
                       ]);

        $this->assertCount(0, $user->tokens);
    }

}
