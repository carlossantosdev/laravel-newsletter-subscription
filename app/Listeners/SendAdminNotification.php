<?php

namespace App\Listeners;

use App\Events\InterestSubscribed;
use App\Mail\InterestSubscriptionAdminMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendAdminNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InterestSubscribed $event): void
    {
        $interest = $event->interestSubscription->interest;
        $admin = User::admin()->first();

        if (is_null($admin)) {
            return;
        }

        Mail::to($admin->email)
            ->send(new InterestSubscriptionAdminMail($admin->name, $interest->name));
    }
}
