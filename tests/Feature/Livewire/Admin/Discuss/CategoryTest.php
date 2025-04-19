<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Discuss;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Discuss\Category;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\User;

class CategoryTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/discuss/category')
            ->assertSeeLivewire(Category::class);
    }

    public function test_categories_are_paginated()
    {
        config(['xetaravel.pagination.discuss.category_per_page' => 3]);
        $this->actingAs(User::find(1));

        $categoryA = DiscussCategory::find(1);
        $categoryB = DiscussCategory::find(4);

        $response = $this->get('/admin/discuss/category');

        $response->assertSee($categoryA->description);
        $response->assertDontSee($categoryB->description);
    }

    public function test_can_sort_categories_by_title()
    {
        $this->actingAs(User::find(1));

        DiscussCategory::create([
            'title' => 'B Category',
            'slug' => 'b-category',
            'color' => '#DDDDDD',
            'icon' => 'fas-search',
            'level' => 5,
            'is_locked' => false,
            'description' => 'B description',
        ]);
        DiscussCategory::create([
            'title' => 'A Category',
            'slug' => 'a-category',
            'color' => '#DDDDDD',
            'icon' => 'fas-search',
            'level' => 6,
            'is_locked' => false,
            'description' => 'A description',
        ]);

        Livewire::test(Category::class)
            ->set('sortField', 'title')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([
                'A Category',
                'B Category'
            ]);
    }

    public function test_can_search_categories()
    {
        $this->actingAs(User::find(1));

        DiscussCategory::create([
            'title' => 'Laravel tips',
            'slug' => 'laravel-tips',
            'color' => '#DDDDDD',
            'icon' => 'fas-search',
            'level' => 5,
            'is_locked' => false,
            'description' => 'Laravel tips',
        ]);
        DiscussCategory::create([
            'title' => 'Symfony guide',
            'slug' => 'symfony-guide',
            'color' => '#DDDDDD',
            'icon' => 'fas-search',
            'level' => 6,
            'is_locked' => false,
            'description' => 'Symfony guide',
        ]);

        Livewire::test(Category::class)
            ->set('search', 'Laravel')
            ->assertSee('Laravel tips')
            ->assertDontSee('Symfony guide');
    }

    public function test_can_select_current_page_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Category::class)
            ->set('selectPage', true)
            ->assertCount('selected', 4);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Category::class)
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

        Livewire::test(Category::class)
            ->set('selected', [1])
            ->assertSee('All threads related to the development and announcements of Xetaravel.')
            ->call('deleteSelected')
            ->assertDontSee('All threads related to the development and announcements of Xetaravel.');
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Category::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
