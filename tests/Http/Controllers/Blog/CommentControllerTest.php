<?php
namespace Tests\Http\Controllers\Blog;

use Xetaravel\Models\User;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        
        $user = User::find(1);
        $this->be($user);
    }


    /**
     * testCreateArticleNotFound method
     *
     * @return void
     */
    public function testCreateArticleNotFound()
    {
        $response = $this->post('/blog/comment/create', ['article_id' => 3]);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }

    /**
     * testCreateValidationFailed method
     *
     * @return void
     */
    public function testCreateValidationFailed()
    {
        $response = $this->post('/blog/comment/create', ['article_id' => 1]);
        $response->assertSessionHas('errors');
        $response->assertStatus(302);
    }

    /**
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $response = $this->post('/blog/comment/create', ['article_id' => 1, 'content' =>  '0123456789']);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }
}
