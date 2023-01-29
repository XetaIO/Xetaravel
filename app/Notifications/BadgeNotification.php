<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\Badge;

class BadgeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The badge instance.
     *
     * @var Badge
     */
    public Badge $badge;

    /**
     * Create a new notification instance.
     *
     * @param Badge $badge
     */
    public function __construct(Badge $badge)
    {
        $this->badge = $badge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
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
            'message_key' => [$this->badge->name],
            'icon' => $this->badge->icon,
            'color' => $this->badge->color,
            'type' => 'badge'
        ];
    }
}
