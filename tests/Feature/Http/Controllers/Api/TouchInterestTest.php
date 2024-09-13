<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Interest;
use App\Models\InterestSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TouchInterestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldNotifyTheSubscribers(): void
    {
        $interest = Interest::factory()->create();
        InterestSubscription::factory()->create(['interest_id' => $interest->id]);

        $response = $this->post(uri: '/api/touch/1', headers: ['accept' => 'application/json']);

        $response->assertStatus(202);
    }

    /**
     * @test
     */
    public function shouldReturn200StatusCodeWhenThereIsNoSubscribersToNotify(): void
    {
        $interest = Interest::factory()->create();

        $response = $this->post(uri: '/api/touch/1', headers: ['accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'There is no subscribers to notify,']);
    }

    /**
     * @test
     */
    public function shouldReturn500StatusCode(): void
    {
        $interest = Interest::factory()->create();
        InterestSubscription::factory()->create(['interest_id' => $interest->id, 'email' => 'error']);

        $response = $this->post(uri: '/api/touch/1', headers: ['accept' => 'application/json']);

        $response->assertStatus(500);
        $response->assertJson(['message' => 'Error on notify the subscribed users.']);
    }
}
