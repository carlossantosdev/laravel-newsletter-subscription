<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Str;

final class CreateUserAction
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute(): User
    {
        $this->data['token'] = Str::random(16);

        return User::create($this->data);
    }
}
