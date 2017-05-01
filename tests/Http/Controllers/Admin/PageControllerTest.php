<?php
namespace Tests\Http\Controllers\Admin;

use Xetaravel\Models\User;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/admin');
        $response->assertSuccessful();
    }

    /**
     * testIndexNotAdmin method
     *
     * @return void
     */
    public function testIndexNotAdmin()
    {
        $user = User::find(3);
        $this->be($user);

        $response = $this->get('/admin');
        $response->assertStatus(302);
    }

    /**
     * testIndexNotAuthenticated method
     *
     * @return void
     */
    public function testIndexNotAuthenticated()
    {
        $response = $this->get('/admin');
        $response->assertStatus(302);
    }
}
