<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\Badge;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\BadgeForm;
use Xetaravel\Models\Badge;

class CreateBadge extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var BadgeForm
     */
    public BadgeForm $form;

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
    #[On('create-badge')]
    public function createBadge(): void
    {
        $this->authorize('create', Badge::class);

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
        $this->authorize('create', Badge::class);

        $this->validate();

        $badge = $this->form->create();

        $this->showModal = false;

        redirect()
            ->route('admin.badge.index')
            ->success("The badge $badge->name has been created successfully !");
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.badge.create-badge');
    }
}
