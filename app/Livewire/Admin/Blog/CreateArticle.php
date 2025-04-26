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
use Throwable;
use Xetaravel\Livewire\Forms\BlogArticleForm;
use Xetaravel\Models\BlogArticle;

class CreateArticle extends Component
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
     * Used to show the create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    #[On('create-article')]
    public function createArticle(): void
    {
        $this->authorize('create', BlogArticle::class);

        $this->form->reset();
        $this->form->searchCategories();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function create(): void
    {
        $this->authorize('create', BlogArticle::class);

        $this->validate();

        $this->form->create();

        redirect()
            ->route('admin.blog.article.index')
            ->success('Your article has been created successfully !');
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.blog.create-article');
    }

    /**
     * We must use a function in the component.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchCategories(string $value = ''): void
    {
        $this->form->searchCategories($value);
    }
}
