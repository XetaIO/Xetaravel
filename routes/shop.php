<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'namespace' => 'Shop',
    'prefix' => 'shop',
    'middleware' => ['permission:access.site,allowGuest', 'display']
], function () {

    // Shop Routes
    Route::get('/', 'ShopController@index')
        ->name('shop.index');

    // Items Routes
    Route::post('item/buy', 'ItemController@buy')
        ->name('shop.item.buy');

    // Category Routes
    Route::get('category/{slug}.{id}', 'CategoryController@show')
        ->name('shop.category.show');
});
