<?php
namespace Xetaravel\Http\Controllers\Admin;

use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;

class SettingController extends Controller
{
    /**
     * Show all the settings.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-wrench mr-2"></i> Manage Settings',
            route('admin.setting.index')
        );

        return view('Admin::Setting.index', compact('breadcrumbs'));
    }
}
