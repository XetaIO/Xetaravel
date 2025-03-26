<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\User;
use Xetaravel\Settings\Settings;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/auth/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::find(1);

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'admin',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::find(1);

        $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_login_disabled(): void
    {
        $settings = app(Settings::class);
        SettingRepository::update($settings, ['app_login_enabled' => false]);
        Toaster::fake();

        $user = User::find(3);
        $user->email_verified_at = now();
        $user->save();

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'member',
        ]);

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect('/');
        Toaster::assertDispatched('The login system is currently disabled, please try again later.');
    }

    public function test_users_can_not_authenticate_without_verified_email(): void
    {
        $user = User::find(2);

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'moderator',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/auth/email/verify/' . base64_encode($user->email));
    }

    public function test_can_logout()
    {
        $this->be(User::find(1));
        $this->assertAuthenticated();

        $response = $this->post('/auth/logout');

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
