<?php

namespace App\Http\Controllers;

use App\Actions\CreateInterestAction;
use App\Http\Requests\CreateInterestRequest;
use App\Http\Resources\InterestResource;
use App\Models\Interest;

class InterestController
{
    public function store(CreateInterestRequest $request)
    {
        if (Interest::where('name', $request->validated('name'))->exists()) {
            return response()->json(data: ['message' => 'Interest already exists. Change the name of the interest and try again.'], status: 422);
        }

        $action = new CreateInterestAction($request->validated());

        return new InterestResource($action->execute());
    }
}
