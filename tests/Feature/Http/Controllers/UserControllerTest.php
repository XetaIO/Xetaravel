<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Models\User;

class UserControllerTest extends TestCase
{
    public function test_show_success()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/users/profile/@admin');
        $response->assertSuccessful();
    }

    public function test_show_user_not_found()
    {
        Toaster::fake();
        $response = $this->get('/users/profile/@admin1337');
        $response->assertStatus(302);
        $response->assertRedirect('/');
        Toaster::assertDispatched('This user does not exist or has been deleted !');
    }

    public function test_delete_success()
    {
        Toaster::fake();
        $this->be(User::find(1));

        $response = $this->delete('/users/delete', ['password' => 'admin']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        Toaster::assertDispatched('Your account has been deleted successfully !');

        $response = $this->get('/users/profile/@admin');
        $response->assertStatus(302);
        Toaster::assertDispatched('This user does not exist or has been deleted !');

        $response = $this->get('/discuss/conversation/this-is-an-announcement.1');
        $response->assertSee('Deleted'); // Deleted Users must be displayed with Deleted username.
    }

    public function test_delete_wrong_password_failed()
    {
        Toaster::fake();
        $this->be(User::find(1));

        $response = $this->delete('/users/delete', ['password' => 'WRONG PASSWORD']);
        $response->assertStatus(302);
        Toaster::assertDispatched('Your Password does not match !');
    }
}
