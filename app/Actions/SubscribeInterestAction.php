<?php

namespace App\Actions;

use App\Models\InterestSubscription;

final class SubscribeInterestAction
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute(): InterestSubscription
    {
        return InterestSubscription::create($this->data);
    }
}
