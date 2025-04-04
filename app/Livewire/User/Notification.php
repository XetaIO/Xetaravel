<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\User;

use Illuminate\Notifications\DatabaseNotificationCollection;
use Livewire\Component;

class Notification extends Component
{
    /**
     * All notifications from the user.
     *
     * @var DatabaseNotificationCollection
     */
    public DatabaseNotificationCollection $notifications;

    /**
     * Whatever the user has un-read notifications.
     *
     * @var bool
     */
    public bool $hasUnreadNotifications = false;

    /**
     * The number of un-red notifications.
     *
     * @var int
     */
    public int $unreadNotificationsCount = 0;

    /**
     * Used to refresh the notifications and the unread count.
     *
     * @return void
     */
    private function fetchData(): void
    {
        $this->notifications = auth()->user()->notifications;

        // Filter only the unread notifications
        $unreadNotifications = $this->notifications->filter(function ($notification) {
            return $notification->read_at === null;
        });
        $this->unreadNotificationsCount = $unreadNotifications->count();

        $this->hasUnreadNotifications = $this->unreadNotificationsCount > 0;
    }

    /**
     * The mount function.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->fetchData();
    }

    public function render()
    {
        return view('livewire.user.notification');
    }

    /**
     * Remove a notification by its id.
     *
     * @param string $notificationId The id of the notification to remove.
     *
     * @return void
     */
    public function remove(string $notificationId): void
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->first();

        // That means the notification id has been modified in front-end.
        if (!$notification) {
            return;
        }
        $notification->delete();

        $this->fetchData();
    }

    /**
     * Mark the notification as read by its id.
     *
     * @param string $notificationId The id of the notification to mark as read.
     *
     * @return void
     */
    public function markAsRead(string $notificationId): void
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->first();

        // That means the notification id has been modified in front-end.
        if (!$notification) {
            return;
        }

        $notification->markAsRead();

        $this->fetchData();
    }

    /**
     * Mark all notifications from the user as read.
     *
     * @return void
     */
    public function markAllNotificationsAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();

        $this->notifications = auth()->user()->notifications;
        $this->unreadNotificationsCount = 0;
        $this->hasUnreadNotifications = false;
    }
}
