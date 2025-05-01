<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\BlogCategory;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->removeListElementClasses('breadcrumb');
        $this->breadcrumbs->addCrumb('<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"' .
            ' viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" ' .
            'stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2' .
            ' 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg> Blog', route('blog.article.index'));
    }

    /**
     * Show the category by his id.
     *
     * @return RedirectResponse|View
     */
    public function show(string $slug, int $id)
    {
        $category = BlogCategory::where('id', $id)->first();

        if (is_null($category)) {
            return redirect()
                ->route('blog.article.index')
                ->error('This category does not exist or has been deleted !');
        }

        $articles = $category->articles()->with('user', 'category')->paginate(config('xetaravel.pagination.blog.article_per_page'));

        $this->breadcrumbs->addCrumb("Category : " . e($category->title), $category->show_url);

        return view(
            'Blog.category.show',
            ['articles' => $articles, 'category' => $category, 'breadcrumbs' => $this->breadcrumbs]
        );
    }
}
