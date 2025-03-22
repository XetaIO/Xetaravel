<?php

declare(strict_types=1);

namespace Http\Controllers\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_redirect_to_comment()
    {
        $response = $this->get('/blog/comment/show/1');
        $response->assertStatus(302);
        $response->assertRedirect(
            '/blog/article/lorem-ipsum-dolor-sit-amet-consectetuer-adipiscing-elit.1?page=1&#comment-1'
        );
    }
}
