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
        'middleware' => ['discuss.maintenance']
], function () {
    // Discuss Routes
    Route::get('/', [Xetaravel\Http\Controllers\Discuss\DiscussController::class, 'index'])
        ->name('discuss.index');

    //  Leaderboard Route
    Route::get('leaderboard', [Xetaravel\Http\Controllers\Discuss\DiscussController::class, 'leaderboard'])
        ->name('discuss.leaderboard');

    // Conversation Routes
    Route::get('conversation/{slug}.{id}', [Xetaravel\Http\Controllers\Discuss\ConversationController::class, 'show'])
        ->name('discuss.conversation.show');

    // BlogCategory Routes
    Route::get('categories', [Xetaravel\Http\Controllers\Discuss\CategoryController::class, 'index'])
        ->name('discuss.category.index');

    // Post Routes
    Route::get('post/show/{id}', [Xetaravel\Http\Controllers\Discuss\PostController::class, 'show'])
        ->name('discuss.post.show');


    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {
        // Post Routes
        Route::get('post/solved/{id}', [Xetaravel\Http\Controllers\Discuss\PostController::class, 'solved'])
            ->name('discuss.post.solved');
    });
});
