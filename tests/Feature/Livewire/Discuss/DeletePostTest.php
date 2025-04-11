<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Livewire\Discuss\DeletePost;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class DeletePostTest extends TestCase
{
    public function test_update_modal()
    {
        $discussPost = DiscussPost::find(2);

        Livewire::actingAs(User::find(1))
            ->test(DeletePost::class)
            ->call('deletePost', $discussPost)
            ->assertSet('discussPost', $discussPost)
            ->assertSet('showModal', true);
    }

    public function test_delete()
    {
        Toaster::fake();
        Event::fake();
        $discussPost = DiscussPost::find(2);

        Livewire::actingAs(User::find(1))
            ->test(DeletePost::class)
            ->call('deletePost', $discussPost)
            ->assertSet('showModal', true)

            ->call('delete')
            ->assertHasNoErrors();

        $this->assertNull(DiscussPost::find(2));

        Toaster::assertDispatched('This post has been deleted successfully !');
        Event::assertDispatched(PostWasDeletedEvent::class);
    }
}
