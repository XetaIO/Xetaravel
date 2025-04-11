<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;

class SocialiteControllerTest extends TestCase
{
    public function test_show_registration_form()
    {
        $response = $this->get('/auth/github/register/form');
        $response->assertStatus(302);
    }

    public function test_redirect_to_provider()
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

    public function test_register_validation_fail()
    {
        $data = ['username' => 'admin', 'email' => 'admin@xetaravel.io'];
        $response = $this->post('/auth/github/register/validate', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['username', 'email']);
    }
}
