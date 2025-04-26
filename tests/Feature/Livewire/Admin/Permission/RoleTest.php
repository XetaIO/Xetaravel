<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Permission;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Permission\Role;
use Xetaravel\Models\User;

class RoleTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/role')
            ->assertSeeLivewire(Role::class);
    }

    public function test_can_sort_roles_by_name()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Role::class)
            ->set('sortField', 'name')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([
                'Administrator',
                'Banished',
                'Developer'
            ]);
    }

    public function test_can_search_roles()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Role::class)
            ->set('search', 'dev')
            ->assertSee('Developer')
            ->assertDontSee('Banished');
    }

    public function test_can_select_current_page_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Role::class)
            ->set('selectPage', true)
            ->assertCount('selected', 5);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Role::class)
            ->set('selectPage', true)
            ->assertSet('selectPage', true)
            ->assertSet('selectAll', false)
            ->assertCount('selected', 5)
            ->set('selectPage', false)
            ->assertSet('selectPage', false)
            ->assertSet('selectAll', false)
            ->assertSet('selected', collect());
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Role::class)
            ->set('selected', [5])
            ->assertSee('Banished')
            ->call('deleteSelected')
            ->assertDontSee('Banished');
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Role::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
