<?php
namespace Tests\Http\Controllers;

use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/users/password/reset');
        $response->assertSuccessful();
    }
}
