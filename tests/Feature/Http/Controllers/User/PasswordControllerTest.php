<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Masmerise\Toaster\Toaster;
use Mockery;
use Tests\TestCase;
use Xetaravel\Models\User;

class PasswordControllerTest extends TestCase
{
    public function test_create_password_if_not_set()
    {
        Toaster::fake();
        $user = User::find(1);
        $user->password = null;
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->post(route('user.password.create'), [
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('Your Password has been created successfully !');

        $this->assertTrue(Hash::check('NewSecurePassword123!', $user->fresh()->password));
    }

    public function test_does_not_create_password_if_already_set()
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        $response = $this->post(route('user.password.create'), [
            'password' => 'SomePassword!',
            'password_confirmation' => 'SomePassword!',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('You have already set a password.');
    }

    public function test_fails_to_create_password_on_save_error()
    {
        Toaster::fake();
        $user = User::find(1);
        $user->password = null;
        $user->save();
        $user->refresh();

        $mock = Mockery::mock($user)->makePartial();
        $mock->shouldReceive('save')->andReturn(false);

        $this->be($mock);

        $response = $this->post(route('user.password.create'), [
            'password' => 'FailPassword123!',
            'password_confirmation' => 'FailPassword123!',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('An error occurred while creating your Password !');
    }

    public function test_updates_password_if_current_matches()
    {
        Toaster::fake();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->put(route('user.password.update'), [
            'current_password' => 'admin',
            'password' => 'NewUpdatedPassword123!',
            'password_confirmation' => 'NewUpdatedPassword123!',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('Your Password has been updated successfully !');

        $this->assertTrue(Hash::check('NewUpdatedPassword123!', $user->fresh()->password));
    }

    public function test_rejects_update_if_current_password_is_invalid()
    {
        Toaster::fake();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->put(route('user.password.update'), [
            'current_password' => 'WrongPassword',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('Your current Password does not match !');

        $this->assertTrue(Hash::check('admin', $user->fresh()->password));
    }

    public function test_fails_to_update_password_on_save_error()
    {
        Toaster::fake();

        $mock = Mockery::mock(User::find(1))->makePartial();
        $mock->shouldReceive('save')->andReturn(false);

        $this->be($mock);

        $response = $this->put(route('user.password.update'), [
            'current_password' => 'admin',
            'password' => 'FailingNewPass123!',
            'password_confirmation' => 'FailingNewPass123!',
        ]);

        $response->assertRedirect(route('user.setting.index'));
        Toaster::assertDispatched('An error occurred while saving your Password !');
    }
}
