<?php
namespace Xetaravel\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Setting;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\Validators\SettingValidator;

class SettingController extends Controller
{
    /**
     * Show all the settings.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $settings = Setting::paginate(10);

        $breadcrumbs = $this->breadcrumbs->addCrumb('Manage Settings', route('admin.setting.index'));

        return view('Admin::Setting.index', compact('settings', 'breadcrumbs'));
    }

    /**
     * Show the setting create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Settings', route('admin.setting.index'))
            ->addCrumb("Create", route('admin.setting.create'));

        return view('Admin::Setting.create', compact('breadcrumbs'));
    }

    /**
     * Handle a setting create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        SettingValidator::create($request->all())->validate();
        SettingRepository::create($request->all());

        return redirect()
            ->route('admin.setting.index')
            ->with('success', 'This setting has been created successfully !');
    }

    /**
     * Show the update form.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the setting.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(Request $request, int $id)
    {
        $setting = Setting::findOrFail($id);

        $breadcrumbs = $this->breadcrumbs
            ->setListElementClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
            ->addCrumb('Manage Settings', route('admin.setting.index'))
            ->addCrumb(
                'Update ' . e($setting->name),
                route('admin.setting.update', $setting->name, $setting->id)
            );

        return view(
            'Admin::Setting.update',
            compact('setting', 'breadcrumbs')
        );
    }

    /**
     * Handle an setting update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the setting to update.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $setting = Setting::findOrFail($id);

        SettingValidator::update($request->all(), $setting->id)->validate();
        SettingRepository::update($request->all(), $setting);

        return redirect()
            ->route('admin.setting.index')
            ->with('success', 'This setting has been updated successfully !');
    }

    /**
     * Handle the delete request for the setting.
     *
     * @param int $id The id of the setting to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $setting = Setting::findOrFail($id);

        if (!$setting->is_deletable) {
            return redirect()
                ->route('admin.setting.index')
                ->with('danger', 'You can not delete this setting !');
        }

        if ($setting->delete()) {
            return redirect()
                ->route('admin.setting.index')
                ->with('success', 'This setting has been deleted successfully !');
        }

        return redirect()
            ->route('admin.setting.index')
            ->with('danger', 'An error occurred while deleting this setting !');
    }
}
