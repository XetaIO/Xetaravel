<?php

/*
|--------------------------------------------------------------------------
| Discuss Routes
|--------------------------------------------------------------------------
*/
Route::group([
        'namespace' => 'Discuss',
        'prefix' => 'discuss',
        'middleware' => ['permission:access.site,allowGuest']
], function () {
    // Discuss Routes
    Route::get('/', 'DiscussController@index')
        ->name('discuss.index');

    // Thread Routes
    Route::get('thread/{slug}.{id}', 'ThreadController@show')
        ->name('discuss.thread.show');

    // Category Routes
    Route::get('categories', 'CategoryController@index')
        ->name('discuss.category.index');
    Route::get('category/{slug}.{id}', 'CategoryController@show')
        ->name('discuss.category.show');

    // Comment Routes
    Route::get('comment/show/{id}', 'CommentController@show')
        ->name('discuss.comment.show');

    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {
        // Thread Routes
        Route::get('thread/create', 'ThreadController@showCreateForm')
            ->name('discuss.thread.create');
        Route::post('thread/create', 'ThreadController@create')
            ->name('discuss.thread.create');

        // Comment Routes
        Route::get('comment/solved/{id}', 'CommentController@markAsSolved')
            ->name('discuss.comment.solved');
    });
});
