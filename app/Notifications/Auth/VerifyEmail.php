<?php

declare(strict_types=1);

namespace Xetaravel\Notifications\Auth;

use Closure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var Closure|null
     */
    public static ?Closure $toMailCallback;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage())
            ->level('primary')
            ->subject('Email Verification')
            ->line('Please click the button below to verify your email address:')
            ->action('Verify my Email', $verificationUrl)
            ->line('If you have not created an account on the ' . config('app.name') . ' site, ' .
            'no further action is required and you can ignore this email.')
            ->from(config('xetaravel.site.contact_email'), config('app.name'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl(mixed $notifiable): string
    {
        return URL::temporarySignedRoute(
            'auth.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => base64_encode($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function toMailUsing(Closure $callback): void
    {
        static::$toMailCallback = $callback;
    }
}
