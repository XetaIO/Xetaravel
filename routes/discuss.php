<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Discuss Routes
|--------------------------------------------------------------------------
*/
Route::group([
        'namespace' => 'Discuss',
        'prefix' => 'discuss',
        'middleware' => ['permission:access.site,allowGuest', 'discuss.maintenance']
], function () {
    // Discuss Routes
    Route::get('/', 'DiscussController@index')
        ->name('discuss.index');

    //  Leaderboard Route
    Route::get('leaderboard', 'DiscussController@leaderboard')
        ->name('discuss.leaderboard');

    // Conversation Routes
    Route::get('conversation/{slug}.{id}', 'ConversationController@show')
        ->name('discuss.conversation.show');

    // BlogCategory Routes
    Route::get('categories', 'CategoryController@index')
        ->name('discuss.category.index');

    // Post Routes
    Route::get('post/show/{id}', 'PostController@show')
        ->name('discuss.post.show');

    // Search Route
    Route::post('search', 'SearchController@index')
        ->name('discuss.search.index');

    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {
        // Conversation Routes
        Route::get('conversation/create', 'ConversationController@showCreateForm')
            ->name('discuss.conversation.create');
        Route::post('conversation/create', 'ConversationController@create')
            ->name('discuss.conversation.create');
        Route::put('conversation/update/{slug}.{id}', 'ConversationController@update')
            ->name('discuss.conversation.update');
        Route::delete('conversation/delete/{slug}.{id}', 'ConversationController@delete')
            ->name('discuss.conversation.delete');

        // Post Routes
        Route::post('post/create', 'PostController@create')
            ->name('discuss.post.create');
        Route::delete('post/delete/{id}', 'PostController@delete')
            ->name('discuss.post.delete');
        Route::put('post/edit/{id}', 'PostController@edit')
            ->name('discuss.post.edit');
        Route::get('post/edit-template/{id}', 'PostController@editTemplate')
            ->name('discuss.post.editTemplate');
        Route::get('post/solved/{id}', 'PostController@solved')
            ->name('discuss.post.solved');
    });
});
