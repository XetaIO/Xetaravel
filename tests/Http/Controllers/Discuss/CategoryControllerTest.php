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

    /**
     * testShow method
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->get('/discuss/category/xetaravel.1');
        $response->assertSuccessful();
    }
}
