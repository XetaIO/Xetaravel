<?php

declare(strict_types=1);

namespace Http\Controllers\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Blog\Comment;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_articles()
    {
        $response = $this->get('/blog');

        $response->assertSuccessful();
    }

    public function test_show_article()
    {
        $response = $this->get('/blog/article/article-1.1');
        $response->assertSuccessful();
        $response->assertSeeLivewire(Comment::class);
    }

    public function test_article_not_found()
    {
        Toaster::fake();
        $response = $this->get('/blog/article/not-found.5');

        Toaster::assertDispatched('This article doesn\'t exist or has been deleted !');
        $response->assertStatus(302);
        $response->assertRedirect('/blog');
    }
}
