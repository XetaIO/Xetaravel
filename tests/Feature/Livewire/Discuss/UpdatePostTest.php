<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Discuss\UpdatePost;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);
        $discussConversation = DiscussConversation::find(1);

        $this->actingAs($user);
        $this->get(route('discuss.conversation.show', ['slug' => $discussConversation->slug, 'id' => $discussConversation->id]))
            ->assertSeeLivewire(UpdatePost::class);
    }

    public function test_update_modal()
    {
        $discussPost = DiscussPost::find(1);

        Livewire::actingAs(User::find(1))
            ->test(UpdatePost::class)
            ->call('updatePost', $discussPost)
            ->assertSet('form.content', $discussPost->content)
            ->assertSet('form.discussPost', $discussPost)
            ->assertSet('showModal', true);
    }

    public function test_update_post()
    {
        Toaster::fake();

        $discussPost = DiscussPost::find(1);
        Livewire::actingAs(User::find(1))
            ->test(UpdatePost::class)
            ->call('updatePost', $discussPost)
            ->set('form.content', 'This is a test of new content')

            ->call('update')
            ->assertHasNoErrors();

        $discussPost = DiscussPost::find(1);
        $this->assertSame('This is a test of new content', $discussPost->content);

        Toaster::assertDispatched('Your reply has been edited successfully !');
    }
}
