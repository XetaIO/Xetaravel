<?php

namespace Xetaravel\Livewire\Admin\Discuss;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\DiscussCategoryForm;
use Xetaravel\Models\DiscussCategory;

class UpdateCategory extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var DiscussCategoryForm
     */
    public DiscussCategoryForm $form;

    /**
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.discuss.update-category');
    }

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param DiscussCategory $discussCategory
     *
     * @return void
     */
    #[On('update-category')]
    public function updateCategory(DiscussCategory $discussCategory): void
    {
        $this->authorize('update', $discussCategory);

        $this->form->reset();
        $this->form->discussCategory = $discussCategory;
        $this->form->title = $discussCategory->title;
        $this->form->color = $discussCategory->color;
        $this->form->icon = $discussCategory->icon;
        $this->form->level = $discussCategory->level;
        $this->form->is_locked = $discussCategory->is_locked;
        $this->form->description = $discussCategory->description;

        $this->showModal = true;
    }

    /**
     * Update the category.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->discussCategory);

        $this->validate();

        $this->form->update();

        redirect()
            ->route('admin.discuss.category.index')
            ->success('Your category has been updated successfully !');
    }
}
