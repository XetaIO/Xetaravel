<?php

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\ShopItem;

class ShopItemRepository
{
    /**
     * Find the latest shop items for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sidebar(): Collection
    {
        return ShopItem::latest()->take(config('xetaravel.shop.items_sidebar'))->get();
    }

    /**
     * Create the new article and save it.
     *
     * @param array $data The data used to create the article.
     *
     * @return \Xetaravel\Models\ShopItem
     */
    public static function create(array $data): ShopItem
    {
        return ShopItem::create([
            'title' => $data['title'],
            'shop_category_id' => $data['shop_category_id'],
            'is_display' => isset($data['is_display']) ? true : false,
            'content' => $data['content'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'quantity' => $data['quantity'],
        ]);
    }

    /**
     * Update the shop item data and save it.
     *
     * @param array $data The data used to update the shop item.
     * @param \Xetaravel\Models\ShopItem $item The shop item to update.
     *
     * @return \Xetaravel\Models\ShopItem
     */
    public static function update(array $data, ShopItem $item): ShopItem
    {
    }
}
