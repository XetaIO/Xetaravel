<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\User;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->be($user);
    }

    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/users/notification');
        $response->assertSuccessful();
    }

    /**
     * testMarkAsRead method
     *
     * @return void
     */
    public function testMarkAsRead()
    {
        $response = $this->json('POST', '/users/notification/markAsRead', ['id' => '123456789']);

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
        $response = $this->json('POST', '/users/notification/markAllAsRead');

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    }

    /**
     * testDelete method
     *
     * @return void
     */
    public function testDelete()
    {
        $response = $this->json('DELETE', '/users/notification/delete/123456789');

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    }
}
