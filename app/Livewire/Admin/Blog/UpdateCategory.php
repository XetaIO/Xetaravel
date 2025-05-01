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

class UpdateCategory extends Component
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
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.blog.update-category');
    }

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param BlogCategory $blogCategory
     *
     * @return void
     */
    #[On('update-category')]
    public function updateCategory(BlogCategory $blogCategory): void
    {
        $this->authorize('update', $blogCategory);

        $this->form->reset();
        $this->form->fill([
            'blogCategory' => $blogCategory,
            'title' => $blogCategory->title,
            'description' => $blogCategory->description,
        ]);

        $this->showModal = true;
    }

    /**
     * Update the category.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->blogCategory);

        $this->validate();

        $this->form->update();

        redirect()
            ->route('admin.blog.category.index')
            ->success('Your category has been updated successfully !');
    }
}
