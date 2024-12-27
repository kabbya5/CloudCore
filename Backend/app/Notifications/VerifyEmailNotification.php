<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    protected $verificationCode;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->verificationCode =  $user->verification_code;
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
            ->subject('Email Verification - YourApp')
            ->greeting('Hello, ' . $this->user->name)
            ->line('Thank you for registering with YourApp! Use the code below to verify your email.')
            ->line('Verification Code: ' . $this->verificationCode)
            ->line('This code will expire in 3 minutes.')
            ->action('Verify Email', url('http://localhost:3000/verify-code/' . $this->user->id))
            ->line('If you did not register, no further action is required.');
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
