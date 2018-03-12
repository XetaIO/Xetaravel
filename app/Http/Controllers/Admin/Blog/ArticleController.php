<?php
namespace Xetaravel\Http\Controllers\Admin\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Article;
use Xetaravel\Models\Category;
use Xetaravel\Models\Repositories\ArticleRepository;
use Xetaravel\Models\Validators\ArticleValidator;

class ArticleController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Blog', route('admin.blog.article.index'));
    }

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
     * Show the article create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $categories = Category::pluck('title', 'id');

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Articles', route('admin.blog.article.index'))
            ->addCrumb("Create", route('admin.blog.article.create'));

        return view('Admin::Blog.article.create', compact('categories', 'breadcrumbs'));
    }

    /**
     * Handle an article create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        ArticleValidator::create($request->all())->validate();
        $article = ArticleRepository::create($request->all());

        $parser = new MentionParser($article);
        $content = $parser->parse($article->content);

        $article->content = $content;
        $article->save();

        return redirect()
            ->route('admin.blog.article.index')
            ->with('success', 'Your article has been created successfully !');
    }

    /**
     * Show the article update form.
     *
     * @param string $slug The slug of the article.
     * @param int $id The id of the article.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
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
        $article = Article::findOrFail($id);

        ArticleValidator::update($request->all(), $id)->validate();
        $article = ArticleRepository::update($request->all(), $article);

        $parser = new MentionParser($article);
        $content = $parser->parse($article->content);

        $article->content = $content;
        $article->save();

        return redirect()
            ->route('admin.blog.article.index')
            ->with('success', 'Your article has been updated successfully !');
    }

    /**
     * Handle the delete request for the article.
     *
     * @param int $id The id of the article to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);

        if ($article->delete()) {
            return redirect()
                ->route('admin.blog.article.index')
                ->with('success', 'This article has been deleted successfully !');
        }

        return redirect()
            ->route('admin.blog.article.index')
            ->with('danger', 'An error occurred while deleting this article !');
    }
}
