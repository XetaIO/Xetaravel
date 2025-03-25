<?php

declare(strict_types=1);

namespace Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Blog\Comment;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_create_comment()
    {
        Toaster::fake();

        Livewire::actingAs(User::find(3))
            ->test(Comment::class, [BlogArticle::find(1)])
            ->set('form.content', 'test comment')
            ->call('create')
            ->assertHasNoErrors('form.content')
            ->assertSet('form.content', '');

        Toaster::assertDispatched('Your comment has been posted successfully !');
    }

    public function test_create_comment_is_flooding()
    {
        config(['xetaravel.flood.blog.comment' => (60 * 10)]);

        Toaster::fake();

        Livewire::actingAs(User::find(2))
            ->test(Comment::class, [BlogArticle::find(1)])
            ->set('form.content', 'test comment')
            ->call('create');

        Toaster::assertDispatched('Wow, keep calm bro, and try to not flood !');
    }

    public function test_create_comment_validation_failed()
    {
        Livewire::actingAs(User::find(1))
            ->test(Comment::class, [BlogArticle::find(1)])
            ->set('form.content', 'test')
            ->call('create')
            ->assertHasErrors('form.content');
    }

    public function test_delete_comment()
    {
        Livewire::actingAs(User::find(2))
            ->test(Comment::class)
            ->set('deleteCommentId', 1)
            ->set('blogCommentCount', 2)
            ->call('delete')
            ->assertDispatched('deleted-event');

        $this->assertNull(BlogComment::find(1));
    }
}
