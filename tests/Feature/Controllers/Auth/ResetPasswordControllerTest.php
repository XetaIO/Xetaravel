<?php
namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    public function test_show_reset_form_success()
    {
        $response = $this->get('/auth/password/reset/123456');
        $response->assertSuccessful();
    }
}
