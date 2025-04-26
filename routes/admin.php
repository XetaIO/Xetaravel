<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => [
        'auth',
        'permission:access administration'
    ]
], function () {
    Route::get('/', [Xetaravel\Http\Controllers\Admin\PageController::class, 'index'])->name('admin.page.index');

    /*
    |--------------------------------------------------------------------------
    | Blog Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'blog',
        'middleware' => ['permission:manage blog article']
    ], function () {

        // BlogArticle Routes
        Route::get('article', [Xetaravel\Http\Controllers\Admin\Blog\ArticleController::class, 'index'])
            ->name('admin.blog.article.index');

        // BlogCategory Routes
        Route::get('category', [Xetaravel\Http\Controllers\Admin\Blog\CategoryController::class, 'index'])
            ->name('admin.blog.category.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Discuss Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'discuss',
        'middleware' => ['permission:manage discuss category']
    ], function () {

        // BlogCategory Routes
        Route::get('category', [Xetaravel\Http\Controllers\Admin\Discuss\CategoryController::class, 'index'])
            ->name('admin.discuss.category.index');
    });

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'user',
        'middleware' => ['permission:manage user']
    ], function () {

        // User Routes
        Route::get('/', [Xetaravel\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('admin.user.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Role & Permission Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'namespace' => 'Role',
        'middleware' => ['permission:manage role|manage permission']
    ], function () {

        // Role Route
        Route::get('role', [Xetaravel\Http\Controllers\Admin\Permission\RoleController::class, 'index'])
            ->name('admin.role.index');

        // Permission Route
        Route::get('permission', [Xetaravel\Http\Controllers\Admin\Permission\PermissionController::class, 'index'])
            ->name('admin.permission.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Setting Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'middleware' => ['permission:manage setting']
    ], function () {

        // Settings Routes
        Route::get('setting', 'SettingController@index')->name('admin.setting.index');

        Route::get('setting/create', 'SettingController@showCreateForm')
            ->name('admin.setting.create');
        Route::post('setting/create', 'SettingController@create')
            ->name('admin.setting.create');

        Route::get('setting/update/{id}', 'SettingController@showUpdateForm')
            ->name('admin.setting.edit');
        Route::put('setting/update/{id}', 'SettingController@update')
            ->name('admin.setting.update');

        Route::delete('setting/delete/{id}', 'SettingController@delete')
            ->name('admin.setting.delete');
    });
});
