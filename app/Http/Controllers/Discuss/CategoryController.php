<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\DiscussCategory;

class CategoryController extends Controller
{
    /**
     * View all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $categories = DiscussCategory::orderBy('title', 'asc')->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb('All Categories', route('discuss.category.index'));

        return view('Discuss::category.index', compact('categories', 'breadcrumbs'));
    }
}
