<?php
namespace Xetaravel\View\Composers\Shop;

use Illuminate\View\View;
use Xetaravel\Models\Repositories\ShopItemRepository;
use Xetaravel\Models\Repositories\ShopCategoryRepository;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $items = ShopItemRepository::sidebar();
        $categories = ShopCategoryRepository::sidebar();

        $view->with(['items' => $items, 'categories' => $categories]);
    }
}
