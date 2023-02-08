<?php
namespace Tests\Http\Controllers\Discuss;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    /**
     * testIndex method
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/discuss/categories');
        $response->assertSuccessful();
    }
}
