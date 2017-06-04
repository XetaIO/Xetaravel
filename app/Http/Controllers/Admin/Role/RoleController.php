<?php
namespace Xetaravel\Http\Controllers\Admin\Role;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Permission;
use Xetaravel\Models\Repositories\RoleRepository;
use Xetaravel\Models\Role;
use Xetaravel\Models\Validators\RoleValidator;

class RoleController extends Controller
{
    /**
     * Show all the roles.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $roles = Role::paginate(10);

        $breadcrumbs = $this->breadcrumbs->addCrumb('Manage Roles', route('admin.role.role.index'));

        return view('Admin::Role.role.index', compact('roles', 'breadcrumbs'));
    }

    /**
     * Show the role create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $permissions = Permission::pluck('name', 'id');

        $optionsAttributes = $this->getOptionAttributes();

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Roles', route('admin.role.role.index'))
            ->addCrumb("Create", route('admin.role.role.create'));

        return view('Admin::Role.role.create', compact('permissions', 'breadcrumbs', 'optionsAttributes'));
    }

    /**
     * Handle a role create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        RoleValidator::create($request->all())->validate();

        $role = RoleRepository::create($request->all());
        $role->syncPermissions($request->get('permissions'));

        return redirect()
            ->route('admin.role.role.index')
            ->with('success', 'This role has been created successfully !');
    }

    /**
     * Show the update form.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the role.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(Request $request, int $id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::pluck('name', 'id');
        $permission = Permission::where('slug', 'access.administration')->first();

        $optionsAttributes = $this->getOptionAttributes();

        $breadcrumbs = $this->breadcrumbs
            ->setListElementClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
            ->addCrumb('Manage Roles', route('admin.role.role.index'))
            ->addCrumb(
                'Update ' . e($role->name),
                route('admin.role.role.update', $role->slug, $role->id)
            );

        return view(
            'Admin::Role.role.update',
            compact('role', 'permissions', 'breadcrumbs', 'optionsAttributes', 'permission')
        );
    }

    /**
     * Handle a role update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the role to update.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        RoleValidator::update($request->all(), $role->id)->validate();
        RoleRepository::update($request->all(), $role);

        $role->syncPermissions($request->get('permissions'));

        return redirect()
            ->back()
            ->with('success', 'This role has been updated successfully !');
    }

    /**
     * Handle the delete request for the role.
     *
     * @param int $id The id of the role to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        if (!$role->is_deletable) {
            return redirect()
                ->route('admin.role.role.index')
                ->with('danger', 'You can not delete this role !');
        }

        // Sync the `user` role on all users for this group.
        foreach ($role->users as $user) {
            // Only do that if the user does not have another role.
            if ($user->roles->count() == 1) {
                $user->roles()->sync(Role::find(3), false);
            }
        }

        if ($role->delete()) {
            return redirect()
                ->route('admin.role.role.index')
                ->with('success', 'This role has been deleted successfully !');
        }

        return redirect()
            ->route('admin.role.role.index')
            ->with('danger', 'An error occurred while deleting this role !');
    }

    /**
     * Return a list of attributes for the permissions option field.
     *
     * @return array
     */
    protected function getOptionAttributes(): array
    {
        $attributes = Permission::pluck('id')->toArray();
        $optionsAttributes = [];

        foreach ($attributes as $attribute) {
            $optionsAttributes[$attribute] = [
                'title' => 'Permission Information',
                'data-content' => Permission::where('id', $attribute)->select('description')->first()->description,
                'data-toggle' => 'popover',
                'data-trigger' => 'hover',
                'data-placement' => 'top'
            ];
        }

        return $optionsAttributes;
    }
}
