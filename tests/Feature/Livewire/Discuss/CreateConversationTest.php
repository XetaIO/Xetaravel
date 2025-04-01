<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Discuss\CreateConversation;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class CreateConversationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/discuss')
            ->assertSeeLivewire(CreateConversation::class);
    }

    public function test_create_modal()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateConversation::class)
            ->call('createConversation')
            ->assertSet('showModal', true);
    }

    public function test_create_new_conversation()
    {
        Toaster::fake();

        Livewire::actingAs(User::find(1))
            ->test(CreateConversation::class)
            ->call('createConversation')
            ->set('form.title', 'Test de titre')
            ->set('form.category_id', 1)
            ->set('form.is_pinned', true)
            ->set('form.is_locked', true)
            ->set('form.content', 'Test de description')

            ->call('create')
            ->assertSet('showModal', false)
            ->assertHasNoErrors();

        $last = DiscussConversation::with('firstPost')
            ->orderBy('id', 'desc')
            ->first();

        $this->assertSame('Test de titre', $last->title);
        $this->assertSame(1, $last->category_id);
        $this->assertSame(true, $last->is_pinned);
        $this->assertSame(true, $last->is_locked);
        $this->assertSame('Test de description', $last->firstPost->content);
        Toaster::assertDispatched('Your discussion has been created successfully !');
    }
}
