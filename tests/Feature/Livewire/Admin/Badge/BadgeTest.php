<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Badge;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Badge\Badge;
use Xetaravel\Models\User;

class BadgeTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/badge')
            ->assertSeeLivewire(Badge::class);
    }

    public function test_can_sort_badges_by_name()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Badge::class)
            ->set('sortField', 'name')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([
                '3rd age club!',
                'A real chatterbox !',
                'A real jeweller!'
            ]);
    }

    public function test_can_search_badges()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Badge::class)
            ->set('search', 'pillar')
            ->assertSee('topLeaderboard')
            ->assertDontSee('onRegister');
    }

    public function test_can_select_current_page_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Badge::class)
            ->set('selectPage', true)
            ->assertCount('selected', 15);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Badge::class)
            ->set('selectPage', true)
            ->assertSet('selectPage', true)
            ->assertSet('selectAll', false)
            ->assertCount('selected', 15)
            ->set('selectPage', false)
            ->assertSet('selectPage', false)
            ->assertSet('selectAll', false)
            ->assertSet('selected', collect());
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Badge::class)
            ->set('selected', [1])
            ->assertSee('topLeaderboard')
            ->call('deleteSelected')
            ->assertDontSee('topLeaderboard');
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Badge::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
