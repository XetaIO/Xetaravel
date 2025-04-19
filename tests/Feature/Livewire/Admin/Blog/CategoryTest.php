<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Blog;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Blog\Category;
use Xetaravel\Models\BlogCategory;
use Xetaravel\Models\User;

class CategoryTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/blog/category')
            ->assertSeeLivewire(Category::class);
    }

    public function test_categories_are_paginated()
    {
        config(['xetaravel.pagination.blog.article_per_page' => 1]);
        $this->actingAs(User::find(1));

        $categoryA = BlogCategory::find(1);
        $categoryB = BlogCategory::find(2);

        $response = $this->get('/admin/blog/category');

        $response->assertSee($categoryA->description);
        $response->assertDontSee($categoryB->description);
    }

    public function test_can_sort_categories_by_title()
    {
        $this->actingAs(User::find(1));

        BlogCategory::create([
            'title' => 'B Category',
            'slug' => 'b-category',
            'description' => 'B description',
        ]);
        BlogCategory::create([
            'title' => 'A Category',
            'slug' => 'a-category',
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

        BlogCategory::create([
            'title' => 'Laravel tips',
            'slug' => 'laravel-tips',
            'description' => 'Laravel tips',
        ]);
        BlogCategory::create([
            'title' => 'Symfony guide',
            'slug' => 'symfony-guide',
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

        BlogCategory::create([
            'title' => 'B Category',
            'slug' => 'b-category',
            'description' => 'B description',
        ]);
        BlogCategory::create([
            'title' => 'A Category',
            'slug' => 'a-category',
            'description' => 'A description',
        ]);

        Livewire::test(Category::class)
            ->set('selectPage', true)
            ->assertCount('selected', 4);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        BlogCategory::create([
            'title' => 'B Category',
            'slug' => 'b-category',
            'description' => 'B description',
        ]);
        BlogCategory::create([
            'title' => 'A Category',
            'slug' => 'a-category',
            'description' => 'A description',
        ]);

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
            ->assertSee('All articles related to Laravel.')
            ->call('deleteSelected')
            ->assertDontSee('All articles related to Laravel.');
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Category::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
