<?php

namespace Tests\Unit\Actions;

use App\Actions\SubscribeInterestAction;
use App\Events\InterestSubscribed;
use App\Models\Interest;
use App\Models\InterestSubscription;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SubscribeInterestActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldCreateInterestSubscriptionWithAllData(): void
    {
        Event::fake([InterestSubscribed::class]);

        $interest = Interest::factory()->create();

        $data = [
            'interest_id' => $interest->id,
            'email' => fake()->unique()->safeEmail(),
        ];

        $action = new SubscribeInterestAction($data);
        $this->assertInstanceOf(InterestSubscription::class, $action->execute());
        $this->assertDatabaseHas('interest_subscriptions', $data);

        Event::assertDispatched(InterestSubscribed::class);
    }

    /**
     * @test
     */
    public function shouldThrownUniqueConstrainViolationExceptionWhenInterestIdAndEmailAlreadyExists(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(UniqueConstraintViolationException::class);

        Event::fake([InterestSubscribed::class]);

        $interest = Interest::factory()->create();

        $data = [
            'interest_id' => $interest->id,
            'email' => fake()->unique()->safeEmail(),
        ];

        $action = new SubscribeInterestAction($data);
        $action->execute();

        Event::assertDispatched(InterestSubscribed::class);

        $action->execute();
        Event::assertNotDispatched(InterestSubscribed::class);
    }
}
