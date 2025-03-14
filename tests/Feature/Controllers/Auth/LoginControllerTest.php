<?php

namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Xetaravel\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/users/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::find(1);

        $response = $this->post('/users/login', [
            'email' => $user->email,
            'password' => 'admin',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::find(1);

        $this->post('/users/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_without_verified_email(): void
    {
        $user = User::find(2);

        $response = $this->post('/users/login', [
            'email' => $user->email,
            'password' => 'moderator',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/users/email/verify/' . sha1($user->email));
    }

    public function test_can_logout()
    {
        $this->be(User::find(1));
        $this->assertAuthenticated();

        $response = $this->post('/users/logout');

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
