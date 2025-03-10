<?php

namespace Xetaravel\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('You received this email because we received a password reset request for your account.')
            ->line('If you have not requested a password reset, no further action is required ' .
                        'and you can ignore this email.')
            ->action(
                'Reset my Password',
                url(config('app.url') . route('users.auth.password.reset', $this->token, false))
            )
            ->level('primary')
            ->subject('Password Reset - ' . config('app.name'))
            ->from(config('xetaravel.site.contact_email'), config('app.name'));
    }
}
