<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin\Discuss;

use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;

class CategoryController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<i class="fa-regular fa-comments mr-2"></i> Discuss',
            route('admin.discuss.category.index')
        );
    }

    /**
     * Show all categories.
     *
     * @return View
     */
    public function index(): View
    {
        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-tags mr-2"></i> Manage Categories',
            route('admin.discuss.category.index')
        );

        return view('Admin::Discuss.category.index', ['breadcrumbs' => $this->breadcrumbs]);
    }
}
