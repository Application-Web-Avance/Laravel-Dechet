<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractReminder extends Notification
{
    use Queueable;

    protected $contract;

    public function __construct($contract)
    {
        $this->contract = $contract;
    }

    public function via($notifiable)
    {
        return ['mail'];  // Make sure mail is included here
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Contract Expiration Reminder')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('Your contract signed on ' . $this->contract->date_signature . ' is expiring soon.')
                    ->action('Review Contract', url('/contracts/' . $this->contract->id))
                    ->line('Thank you for using our service!');
    }
}