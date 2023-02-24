<?php
namespace Tests\Http\Controllers\Admin\Blog;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Xetaravel\Models\Article;
use Xetaravel\Models\User;

class ArticleControllerTest extends TestCase
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
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/admin/blog/article');
        $response->assertSuccessful();
    }

    /**
     * testShowCreateFormSuccess method
     *
     * @return void
     */
    public function testShowCreateFormSuccess()
    {
        $response = $this->get('/admin/blog/article/create');
        $response->assertSuccessful();
    }

    /**
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $data = [
            'title' => 'My article',
            'category_id' => 1,
            'is_display' => 'on',
            'content' => 'My awesome content.'
        ];

        $response = $this->post('/admin/blog/article/create', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $article = Article::where('title', $data['title'])->first();
        $this->assertSame($data['title'], $article->title);
        $this->assertSame('my-article', (string) $article->slug);
        $this->assertSame(1, $article->user_id);
        $this->assertSame($data['category_id'], $article->category_id);
    }

    /**
     * testCreateWithBannerSuccess method
     *
     * @return void
     */
    public function testCreateWithBannerSuccess()
    {
        $file = new UploadedFile(
            public_path('images/articles/default_banner.jpg'),
            'default_banner.jpg',
            'image/jpg',
            null,
            true
        );

        $data = [
            'title' => 'My article',
            'category_id' => 1,
            'is_display' => 'on',
            'content' => 'My awesome content.',
            'banner' => $file
        ];

        $response = $this->post('/admin/blog/article/create', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $article = Article::where('title', $data['title'])->first();
        $this->assertSame($data['title'], $article->title);
        $this->assertSame('my-article', (string) $article->slug);
        $this->assertSame(1, $article->user_id);
        $this->assertSame($data['category_id'], $article->category_id);
        $this->assertStringContainsString('-article.banner.jpg', $article->article_banner);
    }

    /**
     * testShowUpdateFormSuccess method
     *
     * @return void
     */
    public function testShowUpdateFormSuccess()
    {
        $response = $this->get('/admin/blog/article/update/awesome-slug.1');
        $response->assertSuccessful();
    }

    /**
     * testShowUpdateFormArticleNotFound method
     *
     * @return void
     */
    public function testShowUpdateFormArticleNotFound()
    {
        $response = $this->get('/admin/blog/article/update/eww-slug.1337');
        $response->assertStatus(302);
        $response->assertSessionHas('danger');
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $data = [
            'title' => 'My article',
            'category_id' => 2,
            'content' => 'My awesome content.'
        ];

        $response = $this->put('/admin/blog/article/update/1', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $article = Article::find(1);
        $this->assertSame($data['title'], $article->title);
        $this->assertSame('my-article', (string) $article->slug);
        $this->assertSame(false, (bool) $article->is_display);
        $this->assertSame(1, $article->user_id);
        $this->assertSame($data['content'], $article->content);
        $this->assertSame($data['category_id'], $article->category_id);
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateWithBannerSuccess()
    {
        $file = new UploadedFile(
            public_path('images/articles/default_banner.jpg'),
            'default_banner.jpg',
            'image/jpg',
            null,
            true
        );

        $data = [
            'title' => 'My article',
            'category_id' => 2,
            'content' => 'My awesome content.',
            'banner' => $file
        ];

        $response = $this->put('/admin/blog/article/update/1', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $article = Article::find(1);
        $this->assertSame($data['title'], $article->title);
        $this->assertSame('my-article', (string) $article->slug);
        $this->assertSame(false, (bool) $article->is_display);
        $this->assertSame(1, $article->user_id);
        $this->assertSame($data['content'], $article->content);
        $this->assertSame($data['category_id'], $article->category_id);
        $this->assertStringContainsString('-article.banner.jpg', $article->article_banner);
    }
}
