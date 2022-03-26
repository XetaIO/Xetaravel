<?php
namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    /**
     * testShowLinkRequestFormSuccess method
     *
     * @return void
     */
    public function testShowLinkRequestFormSuccess()
    {
        $response = $this->get('/users/password/reset');
        $response->assertSuccessful();
    }

    /**
     * testSendResetLinkEmailSuccess method
     *
     * @return void
     */
    public function testSendResetLinkEmailSuccess()
    {
        $response = $this->post('/users/password/email', ['email' => 'admin@xetaravel.io']);
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
