<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\User;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\Permission\Models\Permission;
use Throwable;
use Xetaravel\Livewire\Forms\UserForm;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

class UpdateUser extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var UserForm
     */
    public UserForm $form;

    /**
     * Used to show the update modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        // Select only the roles attached to this site or the roles without assigned site_id.
        $roles = Role::where('level', '<=', auth()->user()->level)
            ->select(['name', 'color'])
            ->orderBy('name')
            ->get()
            ->toArray();

        // Select all permissions except `bypass login` who is assigned to the `site_id` 0.
        $permissions = Permission::where('name', '<>', 'bypass login')
            ->select(['name', 'description'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('livewire.admin.user.update-user', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param int $id
     *
     * @return void
     */
    #[On('update-user')]
    public function updateUser(int $id): void
    {
        $user = User::withTrashed()
            ->with('account')
            ->find($id);
        $this->authorize('update', $user);

        $this->form->reset();
        $this->form->user = $user;
        $this->form->username = $user->username;
        $this->form->email = $user->email;
        $this->form->first_name = $user->account?->first_name;
        $this->form->last_name = $user->account?->last_name;
        $this->form->facebook = $user->account?->facebook;
        $this->form->twitter = $user->account?->twitter;
        $this->form->biography = $user->account?->biography;
        $this->form->signature = $user->account?->signature;
        $this->form->roles = $user->roles()->pluck('name')->toArray();
        $this->form->permissions = $user->permissions()->pluck('name')->toArray();
        $this->form->can_bypass = $user->hasPermissionTo('bypass login');

        $this->showModal = true;
    }

    /**
     * Update the user.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->user);

        $this->validate();

        $this->form->update();

        redirect()
            ->route('admin.user.index')
            ->success('This user has been updated successfully !');
    }

    /**
     * Restore a user.
     *
     * @return void
     */
    public function restore(): void
    {
        $this->authorize('restore', User::class);

        $this->form->user->restore();

        redirect()
            ->route('admin.user.index')
            ->success('This user has been restored successfully !');
    }

    /**
     * Delete the avatar for the specified user.
     *
     * @param int $id The id of the user.
     *
     * @return void
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function deleteAvatar(int $id): void
    {
        $user = User::findOrFail($id);

        $user->clearMediaCollection('avatar');
        $user->addMedia(public_path('images/avatar.png'))
            ->preservingOriginal()
            ->setName(mb_substr(md5($user->username), 0, 10))
            ->setFileName(mb_substr(md5($user->username), 0, 10) . '.png')
            ->toMediaCollection('avatar');

        redirect()
            ->route('admin.user.index')
            ->success('The avatar has been deleted successfully !');
    }
}
