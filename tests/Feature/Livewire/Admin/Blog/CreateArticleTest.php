<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Blog;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Blog\CreateArticle;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogCategory;
use Xetaravel\Models\User;

class CreateArticleTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/blog/article')
            ->assertSeeLivewire(CreateArticle::class);
    }

    public function test_create_modal()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateArticle::class)
            ->call('createArticle')
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateArticle::class)
            ->set('form.title', '')
            ->set('form.blog_category_id', null)
            ->set('form.content', '')
            ->call('create')
            ->assertHasErrors([
                'form.title' => 'required',
                'form.blog_category_id' => 'required',
                'form.content' => 'required',
            ]);
    }

    public function test_can_create_article_without_banner()
    {
        Toaster::fake();
        $category = BlogCategory::find(1);

        Livewire::actingAs(User::find(1))
            ->test(CreateArticle::class)
            ->set('form.title', 'Test Article')
            ->set('form.blog_category_id', $category->id)
            ->set('form.content', 'This is a test content for the article.')
            ->call('create');

        $this->assertDatabaseHas('blog_articles', [
            'title' => 'Test Article',
            'blog_category_id' => $category->id,
        ]);
        Toaster::assertDispatched('Your article has been created successfully !');
    }

    public function test_can_create_article_with_banner()
    {
        Storage::fake('media');
        Toaster::fake();
        $category = BlogCategory::find(1);

        $banner = UploadedFile::fake()->image('banner.jpg');

        Livewire::actingAs(User::find(1))
            ->test(CreateArticle::class)
            ->set('form.title', 'Article With Banner')
            ->set('form.blog_category_id', $category->id)
            ->set('form.content', 'Content with banner')
            ->set('form.banner', $banner)
            ->call('create');

        $article = BlogArticle::where('title', 'Article With Banner')->first();
        $this->assertNotNull($article);
        $this->assertTrue($article->hasMedia('article'));
        Toaster::assertDispatched('Your article has been created successfully !');
    }
}
