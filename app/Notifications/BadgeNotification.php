<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BadgeNotification extends Notification
{
    use Queueable;

    public $badge;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($badge)
    {
        $this->badge = $badge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'You have unlock the badge <strong>%s</strong> !',
            'message_key' => $this->badge->name,
            'image' => $this->badge->image,
            'type' => 'badge'
        ];
    }
}
