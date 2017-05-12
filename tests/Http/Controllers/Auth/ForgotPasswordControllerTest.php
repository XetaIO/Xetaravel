<?php
namespace Tests\Http\Controllers;

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
        $response = $this->post('/users/password/email', ['email' => 'admin@xeta.io']);
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
