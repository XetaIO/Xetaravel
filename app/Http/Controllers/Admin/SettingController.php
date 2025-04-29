<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\Setting;
use Xetaravel\Settings\Settings;

class SettingController extends Controller
{
    /**
     * Show all the settings.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        $settings = Setting::whereNull('model_type')
            ->whereNull('model_id')
            ->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 320c88.4 0 160-71.6 160-160c0-15.3-2.2-30.1-6.2-44.2c-3.1-10.8-16.4-13.2-24.3-5.3l-76.8 76.8c-3 3-7.1 4.7-11.3 4.7L336 192c-8.8 0-16-7.2-16-16l0-57.4c0-4.2 1.7-8.3 4.7-11.3l76.8-76.8c7.9-7.9 5.4-21.2-5.3-24.3C382.1 2.2 367.3 0 352 0C263.6 0 192 71.6 192 160c0 19.1 3.4 37.5 9.5 54.5L19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L297.5 310.5c17 6.2 35.4 9.5 54.5 9.5zM80 408a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"></path></svg>
                        Settings',
            route('admin.setting.index')
        );

        return view('Admin.setting.index', compact('breadcrumbs', 'settings'));
    }

    /**
     * Update the settings.
     *
     * @param Settings $settings
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Settings $settings, Request $request)
    {
        $this->authorize('update', Setting::class);

        $updated = SettingRepository::update($settings, $request->all());

        if (!$updated) {
            return redirect()
                ->back()
                ->error('Error while saving settings.');
        }

        return redirect()
            ->back()
            ->success('All settings has been updated successfully !');
    }
}
