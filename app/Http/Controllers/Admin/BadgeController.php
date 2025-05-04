<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin;

use Illuminate\View\View;

class BadgeController extends Controller
{
    /**
     * Show the search page.
     *
     * @return View
     */
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M256 48l0 16c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-16L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16l256 0c8.8 0 16-7.2 16-16l0-384c0-8.8-7.2-16-16-16l-64 0zM0 64C0 28.7 28.7 0 64 0L320 0c35.3 0 64 28.7 64 64l0 384c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 64zM160 320l64 0c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16L96 416c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"></path></svg>
                        Manage Badges',
            route('admin.badge.index')
        );

        return view('Admin::badge.index', compact('breadcrumbs'));
    }
}
