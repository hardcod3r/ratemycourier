<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Courier;
use App\Models\Rate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\RateType;

class RateFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_store_rate()
    {
        $courier = Courier::factory()->create();

        $response = $this->postJson('/api/rates', [
            'courier_id' => $courier->id,
            'rate' => 1, // 1 = Like, 2 = Dislike
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);

        $this->assertDatabaseCount('rates', 0);
    }
    public function test_authenticated_user_can_store_rate()
    {
        $user = User::factory()->create();
        $courier = Courier::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/rates', [
            'courier_id' => $courier->id,
            'rate' => 1, // 1 = Like, 2 = Dislike
        ]);

        $response->assertStatus(201); // Δεν επιστρέφεται JSON, απλά 201 status

        $this->assertDatabaseHas('rates', [
            'user_id' => $user->id,
            'courier_id' => $courier->id,
            'rate' => 1,
        ]);
    }

    public function test_authenticated_user_can_update_rate()
    {
        $user = User::factory()->create();
        $courier = Courier::factory()->create();

        // Δημιουργία αρχικής ψήφου
        $rate = Rate::create([
            'user_id' => $user->id,
            'courier_id' => $courier->id,
            'rate' => 1,
        ]);

        $response = $this->actingAs($user)->putJson("/api/rates/{$rate->id}/" . RateType::Dislike);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Rate updated successfully',
                'data' => [
                    'id' => $rate->id,
                    'courier_id' => $courier->id,
                    'user_id' => $user->id,
                    'rate' => 2,
                ],
            ]);

        $this->assertDatabaseHas('rates', [
            'id' => $rate->id,
            'courier_id' => $courier->id,
            'user_id' => $user->id,
            'rate' => 2,
        ]);
    }

    public function test_authenticated_user_can_remove_rate()
    {
        $user = User::factory()->create();
        $courier = Courier::factory()->create();

        $rate = Rate::create([
            'user_id' => $user->id,
            'courier_id' => $courier->id,
            'rate' => 1,
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/rates/{$rate->id}");

        $response->assertStatus(204); // Δεν επιστρέφει JSON, μόνο 204 No Content

        $this->assertDatabaseMissing('rates', [
            'id' => $rate->id,
        ]);
    }

    public function test_authenticated_user_can_get_rate_by_courier_id()
    {
        $user = User::factory()->create();
        $courier = Courier::factory()->create();

        // Δημιουργία ψήφου για τον χρήστη
        $rate = Rate::create([
            'user_id' => $user->id,
            'courier_id' => $courier->id,
            'rate' => 1, // 1 = Like, 2 = Dislike
        ]);

        $response = $this->actingAs($user)->getJson("/api/rates/{$courier->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Rate fetched successfully.',
                'data' => [
                    'id' => $rate->id,
                    'courier_id' => $courier->id,
                    'user_id' => $user->id,
                    'rate' => 1,
                ],
            ]);

        $response->assertJsonPath('data.created_at', fn($value) => !empty($value));
        $response->assertJsonPath('data.updated_at', fn($value) => !empty($value));
        $response->assertJsonPath('timestamp', fn($value) => !empty($value));
    }
}
