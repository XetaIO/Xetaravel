<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\User;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{

    /**
     * testMarkAsRead method
     *
     * @return void
     */
    public function testMarkAsRead()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->json('POST', '/users/notifications/markAsRead', ['id' => '123456789']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    }

    /**
     * testMarkAllAsRead method
     *
     * @return void
     */
    public function testMarkAllAsRead()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->json('POST', '/users/notifications/markAllAsRead');

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    }
}
