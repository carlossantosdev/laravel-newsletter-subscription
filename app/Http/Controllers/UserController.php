<?php

namespace App\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController
{
    public function store(CreateUserRequest $request)
    {
        if (User::where('email', $request->validated('email'))->exists()) {
            return response()->json(data: ['message' => 'Email already exists.'], status: 422);
        }

        $action = new CreateUserAction($request->validated());

        return new UserResource($action->execute());
    }
}
