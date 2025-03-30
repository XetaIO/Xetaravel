<?php

declare(strict_types=1);

namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;

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
     * @param User $notifiable
     *
     * @return array
     */
    public function via(User $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param User $notifiable
     *
     * @return array
     */
    public function toDatabase(User $notifiable): array
    {
        return [
            'message' => "You have unlocked the badge <strong>{$this->badge->name}</strong> !",
            'icon' => $this->badge->icon,
            'color' => $this->badge->color,
            'type' => 'badge',
            'link' => $notifiable->profile_url
        ];
    }
}
