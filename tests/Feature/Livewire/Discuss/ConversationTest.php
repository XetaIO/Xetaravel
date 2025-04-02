<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Discuss\Conversation;
use Xetaravel\Models\User;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/discuss')
            ->assertSeeLivewire(Conversation::class);
    }

    public function test_conversation_with_search_with_result()
    {
        Livewire::withQueryParams(['s' => 'announcement'])
            ->test(Conversation::class)
            ->assertSet('search', 'announcement')
            ->assertDontSee('Maybe try with another word.');
    }

    public function test_conversation_with_search_no_rows()
    {
        Livewire::withQueryParams(['s' => 'xx'])
            ->test(Conversation::class)
            ->assertSet('search', 'xx')
            ->assertSee('Maybe try with another word.');
    }

    public function test_conversation_with_sort_field_allowed()
    {
        Livewire::test(Conversation::class)
            ->set('sortField', 'is_solved')
            ->assertSet('sortField', 'is_solved');
    }

    public function test_conversation_with_sort_field_not_allowed()
    {
        Livewire::test(Conversation::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_conversation_with_sort_field_not_allowed_on_mount()
    {
        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Conversation::class)
            ->assertSet('sortField', 'created_at');
    }

    public function test_conversation_with_category_allowed()
    {
        Livewire::withQueryParams(['c' => 1])
            ->test(Conversation::class)
            ->assertSet('category', 1);
    }

    public function test_conversation_with_category_not_allowed()
    {
        Livewire::withQueryParams(['c' => 30])
            ->test(Conversation::class)
            ->assertSet('category', 0);
    }

    public function test_conversation_with_limit_not_allowed()
    {
        Livewire::test(Conversation::class)
            ->set('limit', 100)
            ->assertSet('limit', config('xetaravel.pagination.discuss.conversation_per_page'));
    }

    public function test_conversation_with_limit_allowed()
    {
        Livewire::test(Conversation::class)
            ->set('limit', 50)
            ->assertSet('limit', 50);
    }
}
