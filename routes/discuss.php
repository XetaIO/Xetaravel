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

    // Conversation Routes
    Route::get('conversation/{slug}.{id}', 'ConversationController@show')
        ->name('discuss.conversation.show');

    // Category Routes
    Route::get('categories', 'CategoryController@index')
        ->name('discuss.category.index');
    Route::get('category/{slug}.{id}', 'CategoryController@show')
        ->name('discuss.category.show');

    // Post Routes
    Route::get('post/show/{id}', 'PostController@show')
        ->name('discuss.post.show');

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
