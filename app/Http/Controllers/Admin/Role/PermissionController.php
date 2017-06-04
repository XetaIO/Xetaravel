<?php
namespace Xetaravel\Http\Controllers\Admin\Role;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Permission;
use Xetaravel\Models\Repositories\PermissionRepository;
use Xetaravel\Models\Validators\PermissionValidator;

class PermissionController extends Controller
{
    /**
     * Show all the permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $permissions = Permission::paginate(10);

        $breadcrumbs = $this->breadcrumbs->addCrumb('Manage Permissions', route('admin.role.permission.index'));

        return view('Admin::Role.permission.index', compact('permissions', 'breadcrumbs'));
    }

    /**
     * Show the permission create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Permissions', route('admin.role.permission.index'))
            ->addCrumb("Create", route('admin.role.permission.create'));

        return view('Admin::Role.permission.create', compact('breadcrumbs'));
    }

    /**
     * Handle a permission create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        PermissionValidator::create($request->all())->validate();
        PermissionRepository::create($request->all());

        return redirect()
            ->route('admin.role.permission.index')
            ->with('success', 'This permission has been created successfully !');
    }

    /**
     * Show the update form.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the permission.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(Request $request, int $id)
    {
        $permission = Permission::findOrFail($id);

        $breadcrumbs = $this->breadcrumbs
            ->setListElementClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
            ->addCrumb('Manage Permissions', route('admin.role.permission.index'))
            ->addCrumb(
                'Update ' . e($permission->name),
                route('admin.role.permission.update', $permission->slug, $permission->id)
            );

        return view(
            'Admin::Role.permission.update',
            compact('permission', 'breadcrumbs')
        );
    }

    /**
     * Handle an permission update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the permission to update.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);

        PermissionValidator::update($request->all(), $permission->id)->validate();
        PermissionRepository::update($request->all(), $permission);

        return redirect()
            ->route('admin.role.permission.index')
            ->with('success', 'This permission has been updated successfully !');
    }

    /**
     * Handle the delete request for the permission.
     *
     * @param int $id The id of the permission to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);

        if (!$permission->is_deletable) {
            return redirect()
                ->route('admin.role.permission.index')
                ->with('danger', 'You can not delete this permission !');
        }

        if ($permission->delete()) {
            return redirect()
                ->route('admin.role.permission.index')
                ->with('success', 'This permission has been deleted successfully !');
        }

        return redirect()
            ->route('admin.role.permission.index')
            ->with('danger', 'An error occurred while deleting this permission !');
    }
}
