<?php
namespace Tests\Http\Controllers\Blog;

use Tests\TestCase;
use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;
use Xetaravel\Models\User;

class CommentControllerTest extends TestCase
{
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
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
        $response->assertStatus(404);
    }

    /**
     * testCreateArticleNotDisplay method
     *
     * @return void
     */
    public function testCreateArticleNotDisplay()
    {
        $article = Article::find(1);
        $article->is_display = false;
        $article->save();

        $response = $this->post('/blog/comment/create', ['article_id' => 1]);
        // The article must not be found since is_display is false and the global scope apply.
        $response->assertSeeText('Not found');
        $response->assertStatus(404);
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
     * testCreateIsFloodingFailed method
     *
     * @return void
     */
    public function testCreateIsFloodingFailed()
    {
        config(['xetaravel.flood.blog.comment' => (60 * 10)]);

        $this->post('/blog/comment/create', ['article_id' => 1, 'content' =>  '0123456789']);

        $response = $this->post('/blog/comment/create', ['article_id' => 1, 'content' =>  '0123456789']);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }

    /**
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $response = $this->post('/blog/comment/create', ['article_id' => 1, 'content' =>  '0123456789 @moderator ds']);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    /**
     * testShow method
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->get('/blog/comment/show/1');
        $response->assertStatus(302);
        $response->assertRedirect(
            '/blog/article/lorem-ipsum-dolor-sit-amet-consectetuer-adipiscing-elit.1?page=1&#comment-1'
        );
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $response = $this->delete('/blog/comment/delete/1');
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertNull(Comment::find(1));
    }
}
