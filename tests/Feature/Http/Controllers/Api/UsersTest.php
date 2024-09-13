<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    private array $userData;

    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd',
        ];

        $this->headers = [
            'accept' => 'application/json',
            'x-token' => 'custom-token',
        ];
    }

    /**
     * @test
     */
    public function shouldCreateUserRecord(): void
    {
        User::factory()->create(['token' => 'custom-token', 'is_admin' => true]);

        $admin = User::find(1);
        $this->actingAs($admin);

        $response = $this->post('/api/users', $this->userData, $this->headers);

        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function shouldReturn401WhenNoAdminTryToCreateANewUser(): void
    {
        User::factory()->create(['token' => 'custom-token']);

        $admin = User::find(1);
        $this->actingAs($admin);

        $response = $this->post('/api/users', $this->userData, $this->headers);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function shouldReturn422StatusCodeWhenUserAlreadyExists(): void
    {
        User::factory()->create(['token' => 'custom-token', 'is_admin' => true]);

        $admin = User::find(1);
        $this->actingAs($admin);

        $response = $this->post('/api/users', $this->userData, $this->headers);

        $response->assertStatus(201);

        $response = $this->post('/api/users', $this->userData, $this->headers);

        $response->assertStatus(422);
    }
}
