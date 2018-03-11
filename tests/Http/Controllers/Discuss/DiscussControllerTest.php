<?php
namespace Tests\Http\Controllers\Discuss;

use Tests\TestCase;

class DiscussControllerTest extends TestCase
{
    /**
     * testIndex method
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/discuss');
        $response->assertSuccessful();
    }
}
