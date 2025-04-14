<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Blog;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Blog\UpdateArticle;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\User;

class UpdateArticleTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/blog/article')
            ->assertSeeLivewire(UpdateArticle::class);
    }

    public function test_modal_opens_and_form_is_populated(): void
    {
        $article = BlogArticle::find(1);

        $this->actingAs(User::find(1));

        Livewire::test(UpdateArticle::class)
            ->call('updateArticle', $article->id)
            ->assertSet('form.title', $article->title)
            ->assertSet('form.blog_category_id', 1)
            ->assertSet('form.content', $article->content)
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(UpdateArticle::class)
            ->call('updateArticle', 1)
            ->set('form.title', '')
            ->set('form.blog_category_id', null)
            ->set('form.content', '')
            ->call('update')
            ->assertHasErrors([
                'form.title' => 'required',
                'form.blog_category_id' => 'required',
                'form.content' => 'required',
            ]);
    }

    public function test_article_is_updated(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        Livewire::test(UpdateArticle::class)
            ->call('updateArticle', 1)
            ->set('form.title', 'Updated title')
            ->set('form.content', 'Updated content with more than ten characters.')
            ->set('form.blog_category_id', 1)
            ->call('update');

        $this->assertDatabaseHas('blog_articles', [
            'id' => 1,
            'title' => 'Updated title',
            'content' => 'Updated content with more than ten characters.',
        ]);
        Toaster::assertDispatched('Your article has been updated successfully !');
    }

    public function test_banner_is_updated(): void
    {
        Toaster::fake();
        Storage::fake('media');
        $article = BlogArticle::find(1);

        $file = UploadedFile::fake()->image('banner.jpg');

        $this->actingAs(User::find(1));

        Livewire::test(UpdateArticle::class)
            ->call('updateArticle', $article->id)
            ->set('form.title', 'Updated title with banner')
            ->set('form.content', 'Content with banner.')
            ->set('form.blog_category_id', 1)
            ->set('form.banner', $file)
            ->call('update');

        $article->refresh();
        $this->assertTrue($article->hasMedia('article'));
        Toaster::assertDispatched('Your article has been updated successfully !');
    }
}
