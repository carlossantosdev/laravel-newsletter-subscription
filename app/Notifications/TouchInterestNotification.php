<?php

namespace App\Notifications;

use App\Models\Interest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TouchInterestNotification extends Notification
{
    use Queueable;

    private Interest $interest;

    /**
     * Create a new notification instance.
     */
    public function __construct(Interest $interest)
    {
        $this->interest = $interest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A new user has subscribed the interest "'.$this->interest->name.'".')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
