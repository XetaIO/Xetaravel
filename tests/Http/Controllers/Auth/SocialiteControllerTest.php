<?php
namespace Tests\Http\Controllers;

use Tests\TestCase;

class SocialiteControllerTest extends TestCase
{
    /**
     * testShowRegistrationForm method
     *
     * @return void
     */
    public function testShowRegistrationForm()
    {
        $response = $this->get('/auth/github/register/form');
        $response->assertSuccessful();
    }

    /**
     * testRedirectToProvider method
     *
     * @return void
     */
    public function testRedirectToProvider()
    {
        $response = $this->get('/auth/github/register');
        $response->assertStatus(302);
        $redirect = urlencode(route('auth.driver.type.callback', ['driver' => 'github', 'type' => 'register']));

        $this->assertContains(
            'https://github.com/login/oauth/authorize?redirect_uri=' . $redirect,
            $response->headers->get('Location')
        );
    }

    /**
     * testRegisterValidationFail method
     *
     * @return void
     */
    public function testRegisterValidationFail()
    {
        $data = ['username' => 'admin', 'email' => 'admin@xeta.io'];
        $response = $this->post('/auth/github/register/validate', $data);
        $response->assertStatus(302);
    }
}
