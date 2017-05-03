<?php
namespace Xetaravel\Http\Controllers\Blog;

use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Blog', route('blog_article_index'));
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
                ->route('blog_article_index')
                ->with('danger', 'This article doesn\'t exist or has been deleted !');
        }

        $comments = $article->comments()->paginate(config('xetaravel.pagination.blog.comment_per_page'));

        $this->breadcrumbs->addCrumb(
            "Article : " . e($article->title),
            route(
                'blog_article_show',
                ['slug' => $article->category->slug, 'id' => $article->category->id]
            )
        );

        return view(
            'Blog::article.show',
            ['article' => $article, 'comments' => $comments, 'breadcrumbs' => $this->breadcrumbs]
        );
    }
}
