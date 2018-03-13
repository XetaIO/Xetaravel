<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => [
        'auth',
        'permission:access.administration',
        'permission:access.site'
    ]
], function () {
        Route::get('/', 'PageController@index')->name('admin.page.index');

        /*
        |--------------------------------------------------------------------------
        | Blog Routes
        |--------------------------------------------------------------------------
        */
        Route::group([
            'namespace' => 'Blog',
            'prefix' => 'blog',
            'middleware' => ['permission:manage.blog']
        ], function () {

            // Article Routes
            Route::get('article', 'ArticleController@index')
                ->name('admin.blog.article.index');

            Route::get('article/create', 'ArticleController@showCreateForm')
                ->name('admin.blog.article.create');
            Route::post('article/create', 'ArticleController@create')
                ->name('admin.blog.article.create');

            Route::get('article/update/{slug}.{id}', 'ArticleController@showUpdateForm')
                ->name('admin.blog.article.edit');
            Route::put('article/update/{id}', 'ArticleController@update')
                ->name('admin.blog.article.update');

            Route::delete('article/delete/{id}', 'ArticleController@delete')
                ->name('admin.blog.article.delete');

            // Category Routes
            Route::get('category', 'CategoryController@index')
                ->name('admin.blog.category.index');

            Route::get('category/create', 'CategoryController@showCreateForm')
                ->name('admin.blog.category.create');
            Route::post('category/create', 'CategoryController@create')
                ->name('admin.blog.category.create');

            Route::get('category/update/{slug}.{id}', 'CategoryController@showUpdateForm')
                ->name('admin.blog.category.edit');
            Route::put('category/update/{id}', 'CategoryController@update')
                ->name('admin.blog.category.update');

            Route::delete('category/delete/{id}', 'CategoryController@delete')
                ->name('admin.blog.category.delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Discuss Routes
        |--------------------------------------------------------------------------
        */
        Route::group([
            'namespace' => 'Discuss',
            'prefix' => 'discuss',
            'middleware' => ['permission:manage.discuss']
        ], function () {

                // Category Routes
            Route::get('category', 'CategoryController@index')
                ->name('admin.discuss.category.index');

            Route::get('category/create', 'CategoryController@showCreateForm')
                ->name('admin.discuss.category.create');
            Route::post('category/create', 'CategoryController@create')
                ->name('admin.discuss.category.create');

            Route::get('category/update/{slug}.{id}', 'CategoryController@showUpdateForm')
                ->name('admin.discuss.category.edit');
            Route::put('category/update/{id}', 'CategoryController@update')
                ->name('admin.discuss.category.update');

            Route::delete('category/delete/{id}', 'CategoryController@delete')
                ->name('admin.discuss.category.delete');
        });

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
        */
        Route::group([
            'namespace' => 'User',
            'prefix' => 'user',
            'middleware' => ['permission:manage.users']
        ], function () {

            // User Routes
            Route::get('/', 'UserController@index')->name('admin.user.user.index');
            Route::get('search', 'UserController@search')->name('admin.user.user.search');

            Route::get('update/{slug}.{id}', 'UserController@showUpdateForm')
                ->name('admin.user.user.edit');
            Route::put('update/{id}', 'UserController@update')
                ->name('admin.user.user.update');

            Route::delete('delete/{id}', 'UserController@delete')
                ->name('admin.user.user.delete');

            Route::delete('deleteAvatar/{id}', 'UserController@deleteAvatar')
                ->name('admin.user.user.deleteavatar');
        });

        /*
        |--------------------------------------------------------------------------
        | Role Routes
        |--------------------------------------------------------------------------
        */
        Route::group([
            'namespace' => 'Role',
            'prefix' => 'role',
            'middleware' => ['permission:manage.roles']
        ], function () {

            // Role Routes
            Route::get('role', 'RoleController@index')->name('admin.role.role.index');

            Route::get('role/create', 'RoleController@showCreateForm')
                ->name('admin.role.role.create');
            Route::post('role/create', 'RoleController@create')
                ->name('admin.role.role.create');

            Route::get('role/update/{id}', 'RoleController@showUpdateForm')
                ->name('admin.role.role.edit');
            Route::put('role/update/{id}', 'RoleController@update')
                ->name('admin.role.role.update');

            Route::delete('role/delete/{id}', 'RoleController@delete')
                ->name('admin.role.role.delete');

            // Permission Route
            Route::get('permission', 'PermissionController@index')->name('admin.role.permission.index');

            Route::get('permission/create', 'PermissionController@showCreateForm')
                ->name('admin.role.permission.create');
            Route::post('permission/create', 'PermissionController@create')
                ->name('admin.role.permission.create');

            Route::get('permission/update/{id}', 'PermissionController@showUpdateForm')
                ->name('admin.role.permission.edit');
            Route::put('permission/update/{id}', 'PermissionController@update')
                ->name('admin.role.permission.update');

            Route::delete('permission/delete/{id}', 'PermissionController@delete')
                ->name('admin.role.permission.delete');
        });
});
