<?php
namespace Xetaravel\Http\Controllers\Admin\Role;

use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;

class PermissionController extends Controller
{
    /**
     * Show all the permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-user-shield mr-2"></i> Manage Permissions',
            route('admin.role.permission.index')
        );

        return view('Admin::Role.permission.index', compact('breadcrumbs'));
    }
}
