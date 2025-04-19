<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\Blog;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\BlogCategoryForm;
use Xetaravel\Models\BlogCategory;

class CreateCategory extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var BlogCategoryForm
     */
    public BlogCategoryForm $form;

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
    #[On('create-category')]
    public function createCategory(): void
    {
        $this->authorize('create', BlogCategory::class);

        $this->form->reset();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorize('create', BlogCategory::class);

        $this->validate();

        $this->form->create();

        $this->showModal = false;

        redirect()
            ->route('admin.blog.category.index')
            ->success('Your category has been created successfully !');
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.blog.create-category');
    }
}
