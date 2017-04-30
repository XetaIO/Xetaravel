<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testShowSuccess()
    {
        $user = User::find(1);
        $this->be($user);
        
        $response = $this->get('/users/profile/xeta.1');
        $response->assertSuccessful();
    }

    /**
     * testShowUserNotFound method
     *
     * @return void
     */
    public function testShowUserNotFound()
    {
        $response = $this->get('/users/profile/not-found.5');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $user = User::find(1);
        $this->be($user);
        
        $response = $this->get('/users/account');
        $response->assertSuccessful();
    }
}
