<?php
namespace Tests\Http\Controllers;

use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    /**
     * testShowResetFormSuccess method
     *
     * @return void
     */
    public function testShowResetFormSuccess()
    {
        $response = $this->get('/users/password/reset/123456');
        $response->assertSuccessful();
    }
}
