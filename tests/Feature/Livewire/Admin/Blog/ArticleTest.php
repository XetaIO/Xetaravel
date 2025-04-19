<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Blog;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Blog\Article;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\User;

class ArticleTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/blog/article')
            ->assertSeeLivewire(Article::class);
    }

    public function test_articles_are_paginated()
    {
        config(['xetaravel.pagination.blog.article_per_page' => 1]);
        $this->actingAs(User::find(1));

        $articleA = BlogArticle::create([
            'title' => 'A Article',
            'slug' => 'a-article',
            'content' => 'A Article',
            'blog_category_id' => 1,
        ]);
        $articleB = BlogArticle::create([
            'title' => 'B Article',
            'slug' => 'b-article',
            'content' => 'B Article',
            'blog_category_id' => 1,
        ]);

        $response = $this->get('/admin/blog/article');

        $response->assertSee($articleA->title);
        $response->assertDontSee($articleB->title);
    }

    public function test_can_sort_articles_by_title()
    {
        $this->actingAs(User::find(1));

        BlogArticle::create([
            'title' => 'B Article',
            'slug' => 'b-article',
            'content' => 'B Article',
            'blog_category_id' => 1,
        ]);
        BlogArticle::create([
            'title' => 'A Article',
            'slug' => 'a-article',
            'content' => 'A Article',
            'blog_category_id' => 1,
        ]);

        Livewire::test(Article::class)
            ->set('sortField', 'title')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([
                'A Article',
                'B Article'
            ]);
    }

    public function test_can_search_articles()
    {
        $this->actingAs(User::find(1));

        BlogArticle::create([
            'title' => 'Laravel tips',
            'slug' => 'laravel-tips',
            'content' => 'Laravel tips',
            'blog_category_id' => 1,
        ]);
        BlogArticle::create([
            'title' => 'Symfony guide',
            'slug' => 'symfony-guide',
            'content' => 'Symfony guide',
            'blog_category_id' => 1,
        ]);

        Livewire::test(Article::class)
            ->set('search', 'Laravel')
            ->assertSee('Laravel tips')
            ->assertDontSee('Symfony guide');
    }

    public function test_can_select_current_page_rows()
    {
        $this->actingAs(User::find(1));

        BlogArticle::create([
            'title' => 'B Article',
            'slug' => 'b-article',
            'content' => 'B Article',
            'blog_category_id' => 1,
        ]);
        BlogArticle::create([
            'title' => 'A Article',
            'slug' => 'a-article',
            'content' => 'A Article',
            'blog_category_id' => 1,
        ]);

        Livewire::test(Article::class)
            ->set('selectPage', true)
            ->assertCount('selected', 3);
    }

    public function test_can_unselect_all_rows_when_deselecting_page()
    {
        $this->actingAs(User::find(1));

        BlogArticle::create([
            'title' => 'B Article',
            'slug' => 'b-article',
            'content' => 'B Article',
            'blog_category_id' => 1,
        ]);
        BlogArticle::create([
            'title' => 'A Article',
            'slug' => 'a-article',
            'content' => 'A Article',
            'blog_category_id' => 1,
        ]);

        Livewire::test(Article::class)
            ->set('selectPage', true)
            ->assertSet('selectPage', true)
            ->assertSet('selectAll', false)
            ->assertCount('selected', 3)
            ->set('selectPage', false)
            ->assertSet('selectPage', false)
            ->assertSet('selectAll', false)
            ->assertSet('selected', collect());
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Article::class)
            ->set('selected', [1])
            ->assertSee('Lorem')
            ->call('deleteSelected')
            ->assertDontSee('Lorem');
    }

    public function test_delete_selected_returns_false_if_no_selection()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Article::class)
            ->call('deleteSelected')
            ->assertReturned(false);
    }
}
