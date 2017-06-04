<?php
namespace Xetaravel\Http\Controllers\Blog;

use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->removeListElementClasses('breadcrumb');
        $this->breadcrumbs->addCrumb('Blog', route('blog.article.index'));
    }

    /**
     * Show the list of all articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('category', 'user')
            ->paginate(config('xetaravel.pagination.blog.article_per_page'));

        return view('Blog::article.index', ['articles' => $articles, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the article by his id.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug, $id)
    {
        $article = Article::with('category', 'user', 'comments')
            ->where('id', $id)
            ->first();

        if (is_null($article)) {
            return redirect()
                ->route('blog.article.index')
                ->with('danger', 'This article doesn\'t exist or has been deleted !');
        }

        $comments = $article->comments()->paginate(config('xetaravel.pagination.blog.comment_per_page'));
        $comments->load('user');

        $breadcrumbs = $this->breadcrumbs->addCrumb("Article : " . e($article->title), $article->article_url);

        return view('Blog::article.show', compact('article', 'comments', 'breadcrumbs'));
    }
}
