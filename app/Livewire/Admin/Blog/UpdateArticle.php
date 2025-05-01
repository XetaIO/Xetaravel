<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\Blog;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\BlogArticleForm;
use Xetaravel\Models\BlogArticle;
use Throwable;

class UpdateArticle extends Component
{
    use AuthorizesRequests;
    use Toastable;
    use WithFileUploads;

    /**
     * The form used to create/update a model.
     *
     * @var BlogArticleForm
     */
    public BlogArticleForm $form;

    /**
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function render(): Factory|Application|View|\Illuminate\View\View
    {
        return view('livewire.admin.blog.update-article');
    }

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param BlogArticle $blogArticle
     *
     * @return void
     */
    #[On('update-article')]
    public function updateArticle(BlogArticle $blogArticle): void
    {
        $this->authorize('update', $blogArticle);

        $this->form->reset();
        $this->form->fill([
            'blogArticle' => $blogArticle,
            'title' => $blogArticle->title,
            'blog_category_id' => $blogArticle->blog_category_id,
            'content' => $blogArticle->content,
            'published_at' => $blogArticle->published_at?->format('Y-m-d H:i'),
        ]);
        $this->form->searchCategories();

        $this->showModal = true;
    }

    /**
     * Update the article.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->blogArticle);

        $this->validate();

        $this->form->update();

        redirect()
            ->route('admin.blog.article.index')
            ->success('Your article has been updated successfully !');
    }
}
