<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Interest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeInterestTest extends TestCase
{
    use RefreshDatabase;

    private array $interestData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->interestData = [
            'interest_id' => 1,
            'email' => 'john@doe.com',
        ];
    }

    /**
     * @test
     */
    public function shouldCreateInterestSubscriptionRecord(): void
    {
        Interest::factory()->create();

        $response = $this->post(
            '/api/subscribe/interest',
            $this->interestData,
            ['accept' => 'application/json']
        );

        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function shouldReturn422StatusCodeWhenTheSubscriptionAlreadyExists(): void
    {
        Interest::factory()->create();

        $response = $this->post(
            '/api/subscribe/interest',
            $this->interestData,
            ['accept' => 'application/json']
        );

        $response->assertStatus(201);

        $response = $this->post(
            '/api/subscribe/interest',
            $this->interestData,
            ['accept' => 'application/json']
        );

        $response->assertStatus(422);
        $response->assertJson(['message' => 'You are already subscribed to this interest list.']);
    }
}
