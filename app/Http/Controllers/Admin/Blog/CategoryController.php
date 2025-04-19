<?php

declare(strict_types=1);

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
            '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"' .
            ' viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" ' .
            'stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2' .
            ' 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg> Blog',
            route('admin.blog.article.index')
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
            '<svg class="w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5L0 80C0 53.5 21.5 32 48 32l149.5 0c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"></path></svg>
                        Manage Categories',
            route('admin.blog.category.index')
        );

        return view('Admin::Blog.category.index', ['breadcrumbs' => $this->breadcrumbs]);
    }
}
