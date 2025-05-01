<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\User;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\User\User as UserComponent;
use Xetaravel\Models\User;

class UserTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/user')
            ->assertSeeLivewire(UserComponent::class);
    }

    public function test_users_are_paginated()
    {
        config(['xetaravel.pagination.user.user_per_page' => 3]);

        $userA = User::find(1);
        $userB = User::find(4);

        $this->actingAs($userA);

        $response = $this->get('/admin/user');

        $response->assertSee($userA->email);
        $response->assertDontSee($userB->email);
    }

    public function test_can_sort_users_by_title()
    {
        $this->actingAs(User::find(1));

        Livewire::test(UserComponent::class)
            ->set('sortField', 'username')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([
                'Admin',
                'Banished',
                'Member'
            ]);
    }

    public function test_can_search_users()
    {
        $this->actingAs(User::find(1));

        Livewire::test(UserComponent::class)
            ->set('search', 'Admin')
            ->assertSee('Admin')
            ->assertDontSee('Moderator');
    }

    public function test_can_select_current_page_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(UserComponent::class)
            ->set('selectPage', true)
            ->assertCount('selected', 4);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        Livewire::test(UserComponent::class)
            ->set('selectPage', true)
            ->assertSet('selectPage', true)
            ->assertSet('selectAll', false)
            ->assertCount('selected', 4)
            ->set('selectPage', false)
            ->assertSet('selectPage', false)
            ->assertSet('selectAll', false)
            ->assertSet('selected', collect());
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(UserComponent::class)
            ->set('selected', [4])
            ->assertSee('Banished')
            ->call('deleteSelected');

        $this->assertTrue(User::withTrashed()->find(4)->trashed());
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(UserComponent::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
