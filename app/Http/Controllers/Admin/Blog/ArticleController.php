<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogCategory;
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

        $this->breadcrumbs->addCrumb(
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"' .
            ' viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" ' .
            'stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2' .
            ' 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg> Blog',
            route('admin.blog.article.index')
        );
    }

    /**
     * Show all articles.
     *
     * @return View
     */
    public function index(): View
    {
        $this->breadcrumbs->addCrumb(
            '<i class="fa-regular fa-newspaper mr-2"></i> Manage Articles',
            route('admin.blog.article.index')
        );

        return view('Admin::Blog.article.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the article create form.
     *
     * @return View
     */
    public function showCreateForm(): View
    {
        $categories = BlogCategory::pluck('title', 'id');

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb(
                '<i class="fa-regular fa-newspaper mr-2"></i> Manage Articles',
                route('admin.blog.article.index')
            )
            ->addCrumb(
                '<i class="fa-solid fa-pencil mr-2"></i> Create',
                route('admin.blog.article.create')
            );

        return view('Admin::Blog.article.create', compact('categories', 'breadcrumbs'));
    }

    /**
     * Handle an article create request for the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        ArticleValidator::create($request->all())->validate();
        $article = ArticleRepository::create($request->all());

        $parser = new MentionParser($article);
        $content = $parser->parse($article->content);

        $article->content = $content;
        $article->save();

        // Default banner for the article.
        $banner = public_path('images/articles/default_banner.jpg');

        if (!is_null($request->file('banner'))) {
            $banner = $request->file('banner');
        }

        $article->clearMediaCollection('article');
        $article->addMedia($banner)
            ->preservingOriginal()
            ->setName(mb_substr(md5($article->slug), 0, 10))
            ->setFileName(
                mb_substr(md5($article->slug), 0, 10) . '.' . (is_string($banner) ? 'jpg' : $banner->extension())
            )
            ->toMediaCollection('article');

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
     * @return RedirectResponse|View
     */
    public function showUpdateForm(string $slug, int $id)
    {
        $article = BlogArticle::with('category', 'user', 'comments')
            ->where('id', $id)
            ->first();

        if (is_null($article)) {
            return redirect()
                ->route('admin.blog.article.index')
                ->with('danger', 'This article doesn\'t exist or has been deleted !');
        }
        $categories = BlogCategory::pluck('title', 'id');

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb(
                '<i class="fa-regular fa-newspaper mr-2"></i> Manage Articles',
                route('admin.blog.article.index')
            )
            ->addCrumb(
                '<i class="fa-solid fa-pen-to-square mr-2"></i> Update : ' . e(Str::limit($article->title, 30)),
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
     * @param Request $request
     * @param int $id The id of the article.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $article = BlogArticle::findOrFail($id);

        ArticleValidator::update($request->all(), $id)->validate();
        $article = ArticleRepository::update($request->all(), $article);

        $parser = new MentionParser($article);
        $content = $parser->parse($article->content);

        $article->content = $content;
        $article->save();

        if (!is_null($request->file('banner')) || $article->article_banner === '/images/articles/default_banner.jpg') {
            // Default banner for the article.
            $banner = public_path('images/articles/default_banner.jpg');

            if (!is_null($request->file('banner'))) {
                $banner = $request->file('banner');
            }

            $article->clearMediaCollection('article');
            $article->addMedia($banner)
                ->preservingOriginal()
                ->setName(mb_substr(md5($article->slug), 0, 10))
                ->setFileName(
                    mb_substr(md5($article->slug), 0, 10) . '.' . (is_string($banner) ? 'jpg' : $banner->extension())
                )
                ->toMediaCollection('article');
        }

        return redirect()
            ->route('admin.blog.article.index')
            ->with('success', 'Your article has been updated successfully !');
    }
}
