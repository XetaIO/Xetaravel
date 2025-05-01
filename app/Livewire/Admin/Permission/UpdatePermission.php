<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\Permission;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Spatie\Permission\Models\Permission;
use Xetaravel\Livewire\Forms\PermissionForm;

class UpdatePermission extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var PermissionForm
     */
    public PermissionForm $form;

    /**
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param Permission $permission
     *
     * @return void
     */
    #[On('update-permission')]
    public function updatePermission(Permission $permission): void
    {
        $this->authorize('update', $permission);

        $this->form->reset();
        $this->form->fill([
            'permission' => $permission,
            'name' => $permission->name,
            'description' => $permission->description,
        ]);

        $this->showModal = true;
    }

    /**
     * Update the permission.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->permission);

        $this->validate();

        $this->form->update();

        redirect()
            ->route('admin.permission.index')
            ->success('Your permission has been updated successfully !');
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.permission.update-permission');
    }
}
