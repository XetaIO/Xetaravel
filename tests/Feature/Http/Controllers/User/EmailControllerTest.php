<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\User;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Models\User;
use Mockery;

class EmailControllerTest extends TestCase
{
    public function test_update_the_authenticated_user_email()
    {
        Toaster::fake();

        $user = User::find(1);

        $this->actingAs($user);

        $newEmail = 'new@example.com';

        $response = $this->put(route('user.email.update'), [
            'email' => $newEmail,
        ]);

        $user->refresh();

        $response->assertRedirect(route('user.setting.index'));
        $this->assertEquals($newEmail, $user->email);
        Toaster::assertDispatched('Your E-mail has been updated successfully !');
    }

    public function test_shows_an_error_if_saving_fails()
    {
        Toaster::fake();

        $mock = Mockery::mock(User::find(1))->makePartial();
        $mock->shouldReceive('save')->andReturn(false);

        $this->be($mock);

        $response = $this->put(route('user.email.update'), [
            'email' => 'fail@example.com',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('An error occurred while saving your E-mail!');

    }
}
