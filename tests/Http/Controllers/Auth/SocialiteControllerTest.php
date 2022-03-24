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
        $response->assertStatus(302);
        $response->assertSessionHas('danger');
    }

    /**
     * testRedirectToProvider method
     *
     * @return void
     */
    public function testRedirectToProvider()
    {
        $response = $this->get('/auth/github/redirect');
        $response->assertStatus(302);
        $redirect = urlencode(route('auth.driver.callback', ['driver' => 'github']));

        $this->assertStringContainsString(
            'https://github.com/login/oauth/authorize?',
            $response->headers->get('Location')
        );

        $this->assertStringContainsString(
            'redirect_uri=' . $redirect,
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
        $data = ['username' => 'admin', 'email' => 'admin@xetaravel.io'];
        $response = $this->post('/auth/github/register/validate', $data);
        $response->assertStatus(302);
    }
}
