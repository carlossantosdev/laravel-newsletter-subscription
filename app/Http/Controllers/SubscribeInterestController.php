<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeInterestAction;
use App\Http\Requests\SubscribeInterestRequest;
use App\Http\Resources\SubscribeInterestResource;
use App\Models\InterestSubscription;

class SubscribeInterestController
{
    public function __invoke(SubscribeInterestRequest $request)
    {
        $validated = $request->validated();
        if (InterestSubscription::where('email', $validated['email'])->where('interest_id', $validated['interest_id'])->exists()) {
            return response()->json(data: ['message' => 'You are already subscribed to this interest list.'], status: 200);
        }

        $action = new SubscribeInterestAction($request->validated());

        return new SubscribeInterestResource($action->execute());
    }
}
