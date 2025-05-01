<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Permission;

use Livewire\Livewire;
use Spatie\Permission\Models\Permission as PermissionModel;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Permission\Permission;
use Xetaravel\Models\User;

class PermissionTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/permission')
            ->assertSeeLivewire(Permission::class);
    }

    public function test_permissions_are_paginated()
    {
        $this->actingAs(User::find(1));

        $categoryA = PermissionModel::find(1);
        $categoryB = PermissionModel::find(20);

        $response = $this->get('/admin/permission');

        $response->assertSee($categoryA->description);
        $response->assertDontSee($categoryB->description);
    }

    public function test_can_sort_permissions_by_name()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permission::class)
            ->set('sortField', 'name')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([
                'access administration',
                'bypass login',
                'create blog article'
            ]);
    }

    public function test_can_search_permissions()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permission::class)
            ->set('search', 'bypass')
            ->assertSee('bypass login')
            ->assertDontSee('access administration');
    }

    public function test_can_select_current_page_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permission::class)
            ->set('selectPage', true)
            ->assertCount('selected', 15);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permission::class)
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

        Livewire::test(Permission::class)
            ->set('selected', [1])
            ->assertSee('bypass login')
            ->call('deleteSelected')
            ->assertDontSee('bypass login');
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permission::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
