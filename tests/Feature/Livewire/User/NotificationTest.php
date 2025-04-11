<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\User;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\User\Notification;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;
use Xetaravel\Notifications\BadgeNotification;

class NotificationTest extends TestCase
{
    public function test_user_has_notification()
    {
        $user = User::find(1);
        $user->notify(new BadgeNotification(Badge::find(2)));

        Livewire::actingAs($user)
            ->test(Notification::class)
            ->assertSet('unreadNotificationsCount', 1)
            ->assertSet('hasUnreadNotifications', true)
            ->assertSet('notifications', $user->notifications);

    }

    public function test_user_can_remove_notification()
    {
        $user = User::find(1);
        $user->notify(new BadgeNotification(Badge::find(2)));

        Livewire::actingAs($user)
            ->test(Notification::class)
            ->call('remove', DatabaseNotification::first()->getKey());

        $this->assertDatabaseEmpty('notifications');
        $this->assertNull(DatabaseNotification::first());
    }

    public function test_user_mark_notification_as_read()
    {
        $user = User::find(1);
        $user->notify(new BadgeNotification(Badge::find(2)));

        $notification = DatabaseNotification::first();
        $this->assertFalse($notification->read());

        Livewire::actingAs($user)
            ->test(Notification::class)
            ->call('markAsRead', $notification->getKey());

        $this->assertTrue(DatabaseNotification::first()->read());
    }

    public function test_user_mark_all_notification_as_read()
    {
        $user = User::find(1);
        $user->notify(new BadgeNotification(Badge::find(2)));
        $user->notify(new BadgeNotification(Badge::find(3)));

        Livewire::actingAs($user)
            ->test(Notification::class)
            ->call('markAllNotificationsAsRead');

        $unreadNotifications = User::find(1)->notifications->filter(function ($notification) {
            return $notification->read_at === null;
        });

        $this->assertSame(0, $unreadNotifications->count());
    }
}
