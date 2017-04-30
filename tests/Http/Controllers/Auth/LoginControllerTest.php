<?php
namespace Tests\Http\Controllers\Auth;

use Xetaravel\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * testShowLoginForm method
     *
     * @return void
     */
    public function testShowLoginForm()
    {
        $response = $this->get('/users/login');
        $response->assertSuccessful();
    }

    /**
     * testLoginSuccess method
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $this->dontSeeIsAuthenticated();
        $data = [
            'email' => 'emeric@xeta.io',
            'password' => '123456789',
            'remember' => 1,
        ];
        $response = $this->post('/users/login', $data);
        $this->seeIsAuthenticated();
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testLoginFailed method
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $this->dontSeeIsAuthenticated();
        $data = [
            'email' => 'emeric@xeta.io',
            'password' => 'wrong-password',
            'remember' => 1,
        ];
        $response = $this->post('/users/login', $data);
        
        $this->dontSeeIsAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testLogoutSuccess method
     *
     * @return void
     */
    public function testLogoutSuccess()
    {
        $this->be(User::find(1));
        $this->seeIsAuthenticated();

        $response = $this->post('/users/logout');
        
        $this->dontSeeIsAuthenticated();
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
