<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Livewire\Discuss\CreatePost;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $discussConversation = DiscussConversation::find(1);
        $discussConversation->is_locked = false;
        $discussConversation->save();

        $this->actingAs(User::find(1));
        $this->get(route('discuss.conversation.show', ['slug' => $discussConversation->slug, 'id' => $discussConversation->id]))
            ->assertSeeLivewire(CreatePost::class);
    }

    public function test_create_new_post()
    {
        Toaster::fake();
        Event::fake();
        $discussConversation = DiscussConversation::find(1);
        $discussConversation->is_locked = false;
        $discussConversation->save();

        Livewire::actingAs(User::find(1))
            ->test(CreatePost::class, ['discussConversation' => $discussConversation])
            ->assertSet('form.conversation_id', $discussConversation->getKey())

            ->set('form.is_pinned', true)
            ->set('form.is_locked', true)
            ->set('form.content', 'This is a post test')
            ->call('create')
            ->assertHasNoErrors();

        $last = DiscussConversation::with('lastPost')
            ->orderBy('id', 'desc')
            ->first();

        $this->assertSame('This is a post test', $last->lastPost->content);
        $this->assertSame(true, $last->is_pinned);
        $this->assertSame(true, $last->is_locked);

        Toaster::assertDispatched('Your reply has been posted successfully !');
        Event::assertDispatched(PostWasCreatedEvent::class);
    }
}
