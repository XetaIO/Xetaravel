<?php
namespace Xetaravel\Http\Controllers\Admin\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Article;
use Xetaravel\Models\Category;
use Xetaravel\Models\Repositories\ArticleRepository;
use Xetaravel\Models\Validators\ArticleValidator;

class ArticleController extends Controller
{
    /**
     * Show all articles.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $articles = Article::with('category', 'user')
            ->paginate(config('xetaravel.pagination.blog.article_per_page'));

        $this->breadcrumbs->addCrumb('Manage Articles', route('admin.blog.article.index'));

        return view('Admin::Blog.article.index', ['articles' => $articles, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the article update form.
     *
     * @param string $slug The slug of the article.
     * @param int $id The id of the article.
     *
     * @return lluminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(string $slug, int $id)
    {
        $article = Article::with('category', 'user', 'comments')
            ->where('id', $id)
            ->first();

        if (is_null($article)) {
            return redirect()
                ->route('admin.blog.article.index')
                ->with('danger', 'This article doesn\'t exist or has been deleted !');
        }
        $categories = Category::pluck('title', 'id');

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Articles', route('admin.blog.article.index'))
            ->addCrumb(
                "Update : " . e(str_limit($article->title, 30)),
                route(
                    'admin.blog.article.index',
                    ['slug' => $article->category->slug, 'id' => $article->category->id]
                )
            );

        return view('Admin::Blog.article.update', compact('article', 'breadcrumbs', 'categories'));
    }

    /**
     * Handle an article update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the article.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        ArticleValidator::update($request->all(), $id)->validate();

        $article = Article::find($id);

        if (ArticleRepository::update($request->all(), $article)) {
            return redirect()
                ->route('admin.blog.article.index')
                ->with('success', 'Your article has been updated successfully !');
        }
    }
}
