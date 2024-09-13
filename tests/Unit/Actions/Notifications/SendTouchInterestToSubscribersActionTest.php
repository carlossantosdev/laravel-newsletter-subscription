<?php

namespace Tests\Unit\Actions\Notifications;

use App\Actions\Notifications\SendTouchInterestToSubscribersAction;
use App\Models\Interest;
use App\Models\InterestSubscription;
use App\Notifications\TouchInterestNotification;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendTouchInterestToSubscribersActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldSendNotificationToSubscribersAndReturnTrue(): void
    {
        Notification::fake();

        $interest = Interest::factory()->create();
        InterestSubscription::factory()->count(2)
            ->state(new Sequence(
                ['interest_id' => $interest->id, 'email' => 'teste1@gmail.com'],
                ['interest_id' => $interest->id, 'email' => 'teste2@gmail.com']
            ))->create();

        // Check Arrange
        $this->assertDatabaseCount('interest_subscriptions', 2);
        $this->assertDatabaseHas('interest_subscriptions', ['interest_id' => $interest->id, 'email' => 'teste1@gmail.com']);
        $this->assertDatabaseHas('interest_subscriptions', ['interest_id' => $interest->id, 'email' => 'teste2@gmail.com']);

        Notification::assertNothingSent();

        $action = new SendTouchInterestToSubscribersAction($interest);
        $this->assertTrue($action->execute());

        Notification::assertSentTo(
            [$interest->subscribers()->get()],
            TouchInterestNotification::class
        );
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenNoSubscribersInTheInterest(): void
    {
        Notification::fake();

        $interest = Interest::factory()->create();

        Notification::assertNothingSent();

        $action = new SendTouchInterestToSubscribersAction($interest);
        $this->assertFalse($action->execute());

        Notification::assertNothingSent();
    }
}
