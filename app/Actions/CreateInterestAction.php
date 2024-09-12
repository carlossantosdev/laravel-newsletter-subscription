<?php

namespace App\Actions;

use App\Models\Interest;

final class CreateInterestAction
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute(): Interest
    {
        return Interest::create($this->data);
    }
}
