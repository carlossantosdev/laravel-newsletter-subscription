<?php

namespace App\Events;

use App\Models\InterestSubscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InterestSubscribed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public InterestSubscription $interestSubscription;

    /**
     * Create a new event instance.
     */
    public function __construct(InterestSubscription $interestSubscription)
    {
        $this->interestSubscription = $interestSubscription;
    }
}
