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
}
