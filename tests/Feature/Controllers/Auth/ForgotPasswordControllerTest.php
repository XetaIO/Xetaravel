<?php
namespace Tests\Feature\Controllers\Auth;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    public function test_show_link_request_form_success()
    {
        $response = $this->get('/auth/password/reset');
        $response->assertSuccessful();
    }

    public function test_send_reset_link_email_success()
    {
        Toaster::fake();
        $response = $this->post('/auth/password/email', ['email' => 'admin@xetaravel.io']);
        $response->assertStatus(302);
        Toaster::assertDispatched('We have e-mailed your password reset link!');
    }
}
