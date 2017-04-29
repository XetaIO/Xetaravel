<?php
namespace Tests\Http\Controllers;

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
}
