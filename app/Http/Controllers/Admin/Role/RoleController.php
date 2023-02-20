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
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-user-tie mr-2"></i> Manage Roles',
            route('admin.role.role.index')
        );

        return view('Admin::Role.role.index', compact('breadcrumbs'));
    }
}
