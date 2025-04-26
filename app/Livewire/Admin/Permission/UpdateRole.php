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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Xetaravel\Livewire\Forms\RoleForm;

class UpdateRole extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var RoleForm
     */
    public RoleForm $form;

    /**
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param Role $role
     *
     * @return void
     */
    #[On('update-role')]
    public function updateRole(Role $role): void
    {
        $this->authorize('update', $role);

        $this->form->reset();
        $this->form->fill([
            'role' => $role,
            'name' => $role->name,
            'color' => $role->color,
            'level' => $role->level,
            'description' => $role->description,
            'permissions' => $role->permissions()->pluck('name')->toArray(),
        ]);

        $this->showModal = true;
    }

    /**
     * Update the role.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->role);

        $this->validate();

        $role = $this->form->update();

        redirect()
            ->route('admin.role.index')
            ->success("The role $role->name has been updated successfully !");
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        // Select all permissions except `bypass login` which is handled by a checkbox.
        $permissions = Permission::where('name', '<>', 'bypass login')
            ->select(['name', 'description'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('livewire.admin.permission.update-role', [
            'permissions' => $permissions,
        ]);
    }
}
