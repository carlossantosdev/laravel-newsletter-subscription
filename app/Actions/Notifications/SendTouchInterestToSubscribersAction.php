<?php

namespace App\Actions\Notifications;

use App\Models\Interest;
use App\Notifications\TouchInterestNotification;
use Exception;

final class SendTouchInterestToSubscribersAction
{
    private Interest $interest;

    public function __construct(Interest $interest)
    {
        $this->interest = $interest;
    }

    public function execute(): bool
    {
        $success = 0;
        $this->interest->subscribers()->each(function ($subscriber) use (&$success) {
            try {
                $subscriber->notify(new TouchInterestNotification($this->interest));
                $success++;
            } catch (Exception $_) {
                $success--;
            }
        });

        if ($success <= 0) {
            return false;
        }

        return true;
    }
}
