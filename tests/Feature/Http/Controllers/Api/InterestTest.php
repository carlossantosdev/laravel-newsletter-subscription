<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldCreateAInterestRecord(): void
    {
        User::factory()->create(['token' => 'custom-token', 'is_admin' => true]);

        $admin = User::find(1);
        $this->actingAs($admin);

        $response = $this->post('/api/interests', [
            'name' => 'Info product 1',
        ], [
            'accept' => 'application/json',
            'x-token' => 'custom-token',
        ]);

        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function shouldReturn422StatusCodeWhenInterestAlreadyExists(): void
    {
        User::factory()->create(['token' => 'custom-token', 'is_admin' => true]);

        $admin = User::find(1);
        $this->actingAs($admin);

        $response = $this->post('/api/interests', [
            'name' => 'Info product 1',
        ], [
            'accept' => 'application/json',
            'x-token' => 'custom-token',
        ]);

        $response->assertStatus(201);

        $response = $this->post('/api/interests', [
            'name' => 'Info product 1',
        ], [
            'accept' => 'application/json',
            'x-token' => 'custom-token',
        ]);

        $response->assertStatus(422);
    }
}
