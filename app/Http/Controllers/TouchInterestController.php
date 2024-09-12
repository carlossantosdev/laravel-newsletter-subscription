<?php

namespace App\Http\Controllers;

use App\Actions\Notifications\SendTouchInterestToSubscribersAction;
use App\Models\Interest;

class TouchInterestController
{
    public function __invoke(Interest $interest)
    {
        $action = new SendTouchInterestToSubscribersAction($interest);

        if (! $action->execute()) {
            return response()->json(data: ['message' => 'Error on notify the subscribed users.'], status: 500);
        }

        return response(status: 202);

    }
}
