<?php
namespace Xetaravel\Http\Controllers\Admin\Blog;

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
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"' .
            ' viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" ' .
            'stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2' .
            ' 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg> Blog',
            route('admin.blog.article.index')
        );
    }

    /**
     * Show all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-tags mr-2"></i> Manage Categories',
            route('admin.blog.category.index')
        );

        return view('Admin::Blog.category.index', ['breadcrumbs' => $this->breadcrumbs]);
    }
}
