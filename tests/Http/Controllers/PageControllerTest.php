<?php
namespace Tests\Http\Controllers;

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
        $response = $this->get('/');
        $response->assertSuccessful();
    }

    /**
     * testIndexBanishedSuccess method
     *
     * @return void
     */
    public function testIndexBanishedSuccess()
    {
        $user = User::find(4);
        $this->be($user);

        $response = $this->get('/');
        $response->assertRedirect('/banished');
    }

    /**
     * testBanishedSuccess method
     *
     * @return void
     */
    public function testBanishedSuccess()
    {
        $user = User::find(4);
        $this->be($user);

        $response = $this->get('/banished');
        $response->assertSuccessful();
    }

    /**
     * testBanishedFailed method
     *
     * @return void
     */
    public function testBanishedFailed()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/banished');
        $response->assertRedirect('/');
    }
}
