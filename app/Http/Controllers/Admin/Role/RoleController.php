<?php
namespace Xetaravel\Http\Controllers\Admin\Role;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Models\Role;
use Ultraware\Roles\Models\Permission;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Validators\RoleValidator;
use Xetaravel\Models\Repositories\RoleRepository;

class RoleController extends Controller
{
    /**
     * Show the search page.
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
        $attributes = Permission::pluck('id')->toArray();

        $optionsAttributes = [];
        foreach ($attributes as $attribute) {
            $optionsAttributes[$attribute] = [
                'title' => 'Role Information',
                'data-content' => Permission::where('id', $attribute)->select('description')->first()->description,
                'data-toggle' => 'popover',
                'data-trigger' => 'hover',
                'data-placement' => 'top'
            ];
        }

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Roles', route('admin.role.role.index'))
            ->addCrumb("Create", route('admin.role.role.create'));

        return view('Admin::Role.role.create', compact('permissions', 'breadcrumbs', 'optionsAttributes'));
    }

    /**
     * Show the update form.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug The slug of the role.
     * @param int $id The id of the role.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(Request $request, string $slug, int $id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::pluck('name', 'id');
        $attributes = Permission::pluck('id')->toArray();
        $permission = Permission::where('slug', 'access.administration')->first();

        $optionsAttributes = [];
        foreach ($attributes as $attribute) {
            $optionsAttributes[$attribute] = [
                'title' => 'Role Information',
                'data-content' => Permission::where('id', $attribute)->select('description')->first()->description,
                'data-toggle' => 'popover',
                'data-trigger' => 'hover',
                'data-placement' => 'top'
            ];
        }

        $breadcrumbs = $this->breadcrumbs
            ->setCssClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
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
     * Handle an user update request for the application.
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
}
