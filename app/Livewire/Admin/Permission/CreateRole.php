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
use Spatie\Permission\Models\Role as RoleModel;
use Xetaravel\Livewire\Forms\RoleForm;

class CreateRole extends Component
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
    #[On('create-role')]
    public function createPermission(): void
    {
        $this->authorize('create', RoleModel::class);

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
        $this->authorize('create', RoleModel::class);

        $this->validate();

        $role = $this->form->create();

        $this->showModal = false;

        redirect()
            ->route('admin.role.index')
            ->success("The role $role->name has been created successfully !");
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        // Select all permissions except `bypass login` which is handled by a checkbox.
        $permissions = Permission::where('name', '<>', 'bypass login')
            ->select(['name', 'description'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('livewire.admin.permission.create-role', [
            'permissions' => $permissions,
        ]);
    }
}
