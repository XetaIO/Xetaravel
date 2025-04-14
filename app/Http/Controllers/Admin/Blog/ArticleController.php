<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin\Blog;

use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;

class ArticleController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"' .
            ' viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" ' .
            'stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2' .
            ' 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg> Blog',
            route('admin.blog.article.index')
        );
    }

    /**
     * Display all articles.
     * Handled by Livewire.
     *
     * @return View
     */
    public function index(): View
    {
        $this->breadcrumbs->addCrumb(
            '<svg class="w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M168 80c-13.3 0-24 10.7-24 24l0 304c0 8.4-1.4 16.5-4.1 24L440 432c13.3 0 24-10.7 24-24l0-304c0-13.3-10.7-24-24-24L168 80zM72 480c-39.8 0-72-32.2-72-72L0 112C0 98.7 10.7 88 24 88s24 10.7 24 24l0 296c0 13.3 10.7 24 24 24s24-10.7 24-24l0-304c0-39.8 32.2-72 72-72l272 0c39.8 0 72 32.2 72 72l0 304c0 39.8-32.2 72-72 72L72 480zM176 136c0-13.3 10.7-24 24-24l96 0c13.3 0 24 10.7 24 24l0 80c0 13.3-10.7 24-24 24l-96 0c-13.3 0-24-10.7-24-24l0-80zm200-24l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"></path></svg>
                        Manage Articles',
            route('admin.blog.article.index')
        );

        return view('Admin::Blog.article.index', ['breadcrumbs' => $this->breadcrumbs]);
    }
}
