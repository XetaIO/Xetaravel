<?php
namespace Xetaravel\Http\Controllers\Shop;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Xetaravel\Models\ShopItem;
use Xetaravel\Notifications\ShopItemNotification;

class ItemController extends Controller
{
    /**
     * Buy the item by his id.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(Request $request)
    {
        $item = ShopItem::findOrFail($request->input('item_id'));
        $user = Auth::user();

        if ($item->hasUser($user)) {
            return back()
                ->with('danger', 'You already own this item !');
        }

        if ($item->quantity == 0) {
            return back()
                ->with('danger', 'There\'s no more quantity for this item.');
        }

        if (!is_null($item->start_at) && $item->start_at->timestamp >= time()) {
            return back()
                ->with('danger', 'The sale of the item has not yet beginning.');
        }

        if (!is_null($item->end_at) && $item->end_at->timestamp <= time()) {
            return back()
                ->with('danger', 'The sale of the item has been finished.');
        }

        if ($user->rubies_total < $item->price) {
            return back()
                ->with('danger', 'You don\'t have enough rubies !.');
        }

        // Attach the new shop_item to the user.
        $result = $user->shopItems()->syncWithoutDetaching($item);

        // Decrement user rubies by the price.
        $user->decrement('rubies_total', $item->price);

        // If the quantity is limited, then decrement the quantity.
        if ($item->quantity >= 1) {
            $item->quantity--;
            $item->save();
        }

        if (!empty($result['attached'])) {
            $user->notify(new ShopItemNotification($item));

            return back()
                ->with('success', 'You have successfully bought the item <b>' . e($item->title) . '</b>');
        } else {
            return back()
                ->with('danger', 'Can not sync the item to your account !');
        }
    }
}
