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
        Route::get('category', 'CategoryController@index')
            ->name('admin.discuss.category.index');
    });

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'namespace' => 'User',
        'prefix' => 'user',
        'middleware' => ['permission:manage user']
    ], function () {

        // User Routes
        Route::get('/', 'UserController@index')->name('admin.user.index');
        Route::get('search', 'UserController@search')->name('admin.user.search');

        Route::get('update/{slug}.{id}', 'UserController@showUpdateForm')
            ->name('admin.user.edit');
        Route::put('update/{id}', 'UserController@update')
            ->name('admin.user.update');

        Route::delete('delete/{id}', 'UserController@delete')
            ->name('admin.user.delete');

        Route::delete('deleteAvatar/{id}', 'UserController@deleteAvatar')
            ->name('admin.user.deleteavatar');
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

        // Role Routes
        Route::get('role', 'RoleController@index')->name('admin.role.index');

        Route::get('role/create', 'RoleController@showCreateForm')
            ->name('admin.role.create');
        Route::post('role/create', 'RoleController@create')
            ->name('admin.role.create');

        Route::get('role/update/{id}', 'RoleController@showUpdateForm')
            ->name('admin.role.edit');
        Route::put('role/update/{id}', 'RoleController@update')
            ->name('admin.role.update');

        Route::delete('role/delete/{id}', 'RoleController@delete')
            ->name('admin.role.delete');

        // Permission Route
        Route::get('permission', 'PermissionController@index')->name('admin.permission.index');

        Route::get('permission/create', 'PermissionController@showCreateForm')
            ->name('admin.permission.create');
        Route::post('permission/create', 'PermissionController@create')
            ->name('admin.permission.create');

        Route::get('permission/update/{id}', 'PermissionController@showUpdateForm')
            ->name('admin.permission.edit');
        Route::put('permission/update/{id}', 'PermissionController@update')
            ->name('admin.permission.update');

        Route::delete('permission/delete/{id}', 'PermissionController@delete')
            ->name('admin.permission.delete');
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
