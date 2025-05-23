<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Blog;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\BlogArticle;

class ArticleController extends Controller
{
    /**
     * Constructor.
     */
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
     * Show the list of all articles.
     *
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function index()
    {
        $articles = BlogArticle::with('category', 'user')
            ->orderByDesc('created_at')
            ->paginate(config('xetaravel.pagination.blog.article_per_page'));

        return view('Blog.article.index', ['articles' => $articles, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the article by his id.
     *
     * @return Application|Factory|RedirectResponse|\Illuminate\View\View|object|View
     */
    public function show(string $slug, int $id)
    {
        $article = BlogArticle::with('category', 'user')
            ->where('id', $id)
            ->first();

        if (is_null($article)) {
            return redirect()
                ->route('blog.article.index')
                ->error('This article does not exist or has been deleted !');
        }

        $url = urlencode(route('blog.article.show', ['slug' => $article->slug, 'id' => $article->getKey()]));
        $title = urlencode($article->title);

        $shareLinks = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'twitter' => "https://x.com/intent/tweet?text={$title}&url={$url}",
            'linkedin' => "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}"
        ];

        $breadcrumbs = $this->breadcrumbs->addCrumb('<svg xmlns="http://www.w3.org/2000/svg" fill="none"' .
        ' viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2"><path ' .
        'stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125' .
        ' 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621' .
        ' 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0' .
        ' 00-9-9z" /></svg> Article : ' . e($article->title), $article->show_url);

        return view('Blog.article.show', compact('article', 'breadcrumbs', 'shareLinks'));
    }
}
