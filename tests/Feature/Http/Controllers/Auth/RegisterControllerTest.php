<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\User;
use Xetaravel\Settings\Settings;

class RegisterControllerTest extends TestCase
{
    public function test_register_screen_can_be_rendered()
    {
        $response = $this->get('/auth/register');

        $response->assertSuccessful();
    }

    public function test_users_can_register_using_the_login_screen()
    {
        $this->assertNull(User::find(5));
        Toaster::fake();

        $data = [
            'username' => 'Jhon',
            'email' => 'joe@gmail.com',
            'password' => 'Lu123456789+',
            'password_confirmation' => 'Lu123456789+',
            'terms' => 1,
        ];
        $response = $this->post('/auth/register', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        Toaster::assertDispatched('Your account has been created successfully !');
    }

    public function test_users_can_not_register_with_register_disabled(): void
    {
        $settings = app(Settings::class);
        SettingRepository::update($settings, ['app_register_enabled' => false]);
        Toaster::fake();

        $data = [
            'username' => 'Jhon',
            'email' => 'joe@gmail.com',
            'password' => 'Lu123456789+',
            'password_confirmation' => 'Lu123456789+',
            'terms' => 1,
        ];
        $response = $this->post('/auth/register', $data);

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect('/');
        Toaster::assertDispatched('The register system is currently disabled, please try again later.');
    }
}
