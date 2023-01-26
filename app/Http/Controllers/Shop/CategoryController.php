<?php
namespace Xetaravel\Http\Controllers\Shop;

use Xetaravel\Models\ShopCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->removeListElementClasses('breadcrumb');
        $this->breadcrumbs->addCrumb('Blog', route('blog.article.index'));
    }

    /**
     * Show the article by his id.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, $slug, $id)
    {
        $category = ShopCategory::with('items')
            ->where('id', $id)
            ->first();

        if (is_null($category)) {
            return redirect()
                ->route('shop.article.index')
                ->with('danger', 'This category doesn\'t exist or has been deleted !');
        }

        $articles = $category->articles()->paginate(config('xetaravel.pagination.blog.article_per_page'));

        $this->breadcrumbs->addCrumb("Category : " . e($category->title), $category->category_url);

        return view(
            'Blog::category.show',
            ['articles' => $articles, 'category' => $category, 'breadcrumbs' => $this->breadcrumbs]
        );
    }
}
