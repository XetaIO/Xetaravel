<?php
namespace Tests\Http\Controllers\Auth;

use Xetaravel\Models\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * testShowRegistrationForm method
     *
     * @return void
     */
    public function testShowRegistrationForm()
    {
        $response = $this->get('/users/register');
        $response->assertSuccessful();
    }

    /**
     * testRegisterSuccess method
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $this->assertNull(User::find(5));

        $data = [
            'username' => 'Jhon',
            'email' => 'joe@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'terms' => 1,
        ];
        $response = $this->post('/users/register', $data);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertInstanceOf(User::class, User::find(5), 'Must be an instance of User.');
    }
}
