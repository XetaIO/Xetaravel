<?php
namespace Tests\Http\Controllers\Blog;

use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/blog');
        $response->assertSuccessful();
    }

    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testShowSuccess()
    {
        $response = $this->get('/blog/article/article-1.1');
        $response->assertSuccessful();
    }

    /**
     * testShowArticleNotFound method
     *
     * @return void
     */
    public function testShowArticleNotFound()
    {
        $response = $this->get('/blog/article/not-found.5');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/blog');
    }
}
