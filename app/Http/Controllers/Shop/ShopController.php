<?php
namespace Xetaravel\Http\Controllers\Shop;

use Illuminate\View\View;
use Xetaravel\Models\ShopItem;

class ShopController extends Controller
{
    /**
     * Display all items.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $items = ShopItem::with('shopCategory', 'user')
            ->orderByDesc('created_at')
            ->paginate(config('xetaravel.pagination.shop.item_per_page'));

        $breadcrumbs = $this->breadcrumbs;

        return view('Shop::index', compact('breadcrumbs', 'items'));
    }
}
