<?php
namespace Xetaravel\Http\Controllers\Blog;

use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Blog', route('blog_article_index'));
    }

    /**
     * Show the article by his id.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug, $id)
    {
        $category = Category::with('articles')
            ->where('id', $id)
            ->first();

        if (is_null($category)) {
            return redirect()
                ->route('blog_article_index')
                ->with('danger', 'This category doesn\'t exist or has been deleted !');
        }

        $articles = $category->articles()->paginate(10);

        $this->breadcrumbs->addCrumb(
            "Category : " . e($category->title),
            route(
                'blog_article_show',
                ['slug' => $category->slug, 'id' => $category->id]
            )
        );

        return view(
            'Blog::category.show',
            ['articles' => $articles, 'category' => $category, 'breadcrumbs' => $this->breadcrumbs]
        );
    }
}
