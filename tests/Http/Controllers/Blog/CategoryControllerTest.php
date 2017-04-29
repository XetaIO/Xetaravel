<?php
namespace Tests\Http\Controllers\Blog;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testShowSuccess()
    {
        $response = $this->get('/blog/category/laravel.1');
        $response->assertSuccessful();
    }

    /**
     * testShowCategoryNotFound method
     *
     * @return void
     */
    public function testShowCategoryNotFound()
    {
        $response = $this->get('/blog/category/not-found.5');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/blog');
    }
}
