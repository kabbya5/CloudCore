<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    protected $verificationCode;
    protected $expiresAt;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->verificationCode = rand(100000, 999999);
        $this->expiresAt = Carbon::now()->addMinutes(3);
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
    public function toMail($notifiable)
    {

        $encryptedCode = Crypt::encryptString($this->verificationCode);
        $encryptedExpiresAt = Crypt::encryptString($this->expiresAt);

        return (new MailMessage)
            ->subject('Email Verification - YourApp')
            ->greeting('Hello, ' . $this->user->name)
            ->line('Thank you for registering with YourApp! Use the code below to verify your email.')
            ->line('Verification Code: ' . $this->verificationCode)
            ->line('This code will expire in 3 minutes.')
            ->action('Verify Email', url('/verify-code/' . $this->user->id . '/' . $encryptedCode . '/' . $encryptedExpiresAt))
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
