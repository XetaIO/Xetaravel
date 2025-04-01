<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Livewire\Discuss\UpdateConversation;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class UpdateConversationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);
        $discussConversation = DiscussConversation::find(1);

        $this->actingAs($user);
        $this->get(route('discuss.conversation.show', ['slug' => $discussConversation->slug, 'id' => $discussConversation->id]))
            ->assertSeeLivewire(UpdateConversation::class);
    }

    public function test_update_modal()
    {
        $old = DiscussConversation::find(1);

        Livewire::actingAs(User::find(1))
            ->test(UpdateConversation::class, ['discussConversation' => $old])
            ->call('updateConversation')
            ->assertSet('form.title', $old->title)
            ->assertSet('form.category_id', $old->category_id)
            ->assertSet('form.is_pinned', $old->is_pinned)
            ->assertSet('form.is_locked', $old->is_locked)
            ->assertSet('showModal', true);
    }

    public function test_update_conversation()
    {
        Toaster::fake();
        Event::fake();

        $old = DiscussConversation::find(1);
        Livewire::actingAs(User::find(1))
            ->test(UpdateConversation::class, ['discussConversation' => $old])
            ->call('updateConversation')
            ->set('form.title', 'New title')
            ->set('form.category_id', 2)
            ->set('form.is_pinned', false)
            ->set('form.is_locked', false)

            ->call('update')
            ->assertHasNoErrors();

        $last = DiscussConversation::find(1);
        $this->assertSame('New title', $last->title);
        $this->assertSame(2, $last->category_id);
        $this->assertSame(false, $last->is_pinned);
        $this->assertSame(false, $last->is_locked);

        Toaster::assertDispatched('Your discussion has been updated successfully !');
        Event::assertDispatched(TitleWasChangedEvent::class);
        Event::assertDispatched(CategoryWasChangedEvent::class);
    }

}
