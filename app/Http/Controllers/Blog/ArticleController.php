<?php
namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
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
        $articles = Article::with('category', 'user')->paginate(10);

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

        $comments = $article->comments()->paginate(10);

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