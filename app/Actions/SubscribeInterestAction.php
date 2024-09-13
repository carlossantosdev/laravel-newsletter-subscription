<?php

namespace App\Actions;

use App\Events\InterestSubscribed;
use App\Models\InterestSubscription;

class SubscribeInterestAction
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute(): InterestSubscription
    {
        $interestSubscription = InterestSubscription::create($this->data);

        if ($interestSubscription) {
            $this->notifyAdmins($interestSubscription);
        }

        return $interestSubscription;
    }

    private function notifyAdmins(InterestSubscription $interestSubscription): void
    {
        InterestSubscribed::dispatch($interestSubscription);
    }
}
