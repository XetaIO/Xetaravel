<?php
namespace Tests\Http\Controllers\Discuss;

use Tests\TestCase;

class SearchControllerTest extends TestCase
{

    /**
     * testSearch method
     *
     * @return void
     */
    public function testSearch()
    {
        $response = $this->post('/discuss/search', ['search' => 'anno']);
        $response->assertSuccessful();
        $response->assertSee('This is an announcement.');
    }

    /**
     * testSearchInPost method
     *
     * @return void
     */
    public function testSearchInPost()
    {
        $response = $this->post('/discuss/search', ['search' => 'Lorem']);
        $response->assertSuccessful();
        $response->assertSee('This is an announcement.');
    }

    /**
     * testSearchInPost method
     *
     * @return void
     */
    public function testSearchNotFound()
    {
        $response = $this->post('/discuss/search', ['search' => 'Test']);
        $response->assertSuccessful();
        $response->assertDontSee('This is an announcement.');
    }
}
