<?php
namespace Xetaravel\Http\Controllers\Shop;

use Xetaravel\Models\ShopCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Show the category by his id and all the related items.
     *
     * @param string $slug The slug of the category.
     * @param int $id The id of the category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, string $slug, int $id)
    {
        $category = ShopCategory::with('shopItems')
            ->where('id', $id)
            ->first();

        if (is_null($category)) {
            return redirect()
                ->route('shop.index')
                ->with('danger', 'This category doesn\'t exist or has been deleted !');
        }

        $items = $category->shopItems()->paginate(config('xetaravel.pagination.shop.item_per_page'));

        $this->breadcrumbs->addCrumb("Category : " . e($category->title), $category->category_url);

        return view(
            'Shop::category.show',
            ['items' => $items, 'category' => $category, 'breadcrumbs' => $this->breadcrumbs]
        );
    }
}
