<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\DiscussCategory;

class CategoryController extends Controller
{
    /**
     * View all categories.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = DiscussCategory::orderBy('level', 'asc')->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-list mr-2"></i> All Categories',
            route('discuss.category.index')
        );

        return view('Discuss::category.index', compact('categories', 'breadcrumbs'));
    }
}
