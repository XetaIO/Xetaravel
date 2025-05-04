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

class UpdateBadge extends Component
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
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param Badge $badge
     *
     * @return void
     */
    #[On('update-badge')]
    public function updateBadge(Badge $badge): void
    {
        $this->authorize('update', $badge);

        $this->form->reset();
        $this->form->fill([
            'badge' => $badge,
            'name' => $badge->name,
            'icon' => $badge->icon,
            'color' => $badge->color,
            'type' => $badge->type,
            'rule' => $badge->rule,
            'description' => $badge->description,
        ]);

        $this->showModal = true;
    }

    /**
     * Update the badge.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->badge);

        $this->validate();

        $badge = $this->form->update();

        redirect()
            ->route('admin.badge.index')
            ->success("The badge $badge->name has been updated successfully !");
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.badge.update-badge');
    }
}
