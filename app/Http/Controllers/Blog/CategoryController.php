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
        $this->breadcrumbs->addCrumb('Blog', route('blog.article.index'));
    }

    /**
     * Show the category by his id.
     *
     * @return RedirectResponse|View
     */
    public function show(string $slug, int $id)
    {
        $category = BlogCategory::with('articles')
            ->where('id', $id)
            ->first();

        if (is_null($category)) {
            return redirect()
                ->route('blog.article.index')
                ->error('This category does not exist or has been deleted !');
        }

        $articles = $category->articles()->paginate(config('xetaravel.pagination.blog.article_per_page'));

        $this->breadcrumbs->addCrumb("Category : " . e($category->title), $category->category_url);

        return view(
            'Blog.category.show',
            ['articles' => $articles, 'category' => $category, 'breadcrumbs' => $this->breadcrumbs]
        );
    }
}
