<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\User;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Models\DatabaseNotification;
use Xetaravel\Models\Newsletter;
use Xetaravel\Models\User;
use Xetaravel\Notifications\MentionNotification;

class NotificationControllerTest extends TestCase
{
    public function test_index_view_is_returned_with_correct_data(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        DatabaseNotification::factory()
            ->count(3)
            ->create([
                'type' => MentionNotification::class,
                'notifiable_id' => $user->id,
                'notifiable_type' => get_class($user),
            ]);

        DatabaseNotification::factory()
            ->unread()
            ->create([
                'type' => MentionNotification::class,
                'notifiable_id' => $user->id,
                'notifiable_type' => get_class($user),
            ]);

        Newsletter::factory()->create([
            'email' => $user->email
        ]);

        $response = $this->get(route('user.notification.index'));

        $response->assertOk();
        $response->assertViewIs('notification.index');
        $response->assertViewHasAll([
            'user',
            'breadcrumbs',
            'notifications',
            'hasUnreadNotifications',
            'newsletter'
        ]);

        $this->assertTrue($response->viewData('hasUnreadNotifications'));
    }

    public function test_delete_notification_success(): void
    {
        Toaster::fake();
        $user = User::find(1);
        $this->actingAs($user);

        $notification = DatabaseNotification::factory()
            ->create([
                'type' => MentionNotification::class,
                'notifiable_id' => $user->id,
                'notifiable_type' => get_class($user),
            ]);

        $response = $this->delete(route('user.notification.delete', $notification->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
        Toaster::assertDispatched('The notification has been deleted.');
    }


    public function test_delete_unknown_notification(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        $response = $this->delete(route('user.notification.delete', 'invalid-id'));

        $response->assertRedirect();
        Toaster::assertDispatched('An error occurred while deleting the notification.');
    }
}
