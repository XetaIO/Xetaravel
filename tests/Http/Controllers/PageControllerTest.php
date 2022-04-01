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

    /**
     * testTermsSuccess method
     *
     * @return void
     */
    public function testTermsSuccess()
    {
        $response = $this->get('/terms');
        $response->assertSuccessful();
    }

    /**
     * testShowContactSuccess method
     *
     * @return void
     */
    public function testShowContactSuccess()
    {
        $response = $this->get('/contact');
        $response->assertSuccessful();
    }

    /**
     * testContactSuccess method
     *
     * @return void
     */
    public function testContactSuccess()
    {
        $data = [
            'name' => 'Test Setting',
            'email' => 'my-email@xetaravel.io',
            'subject' => 'Subject of the Mail',
            'message' => 'Test de message de mail.',
            'ip' => '127.0.0.1'
        ];
        $response = $this->post('/contact', $data);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }
}
