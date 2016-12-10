<?php
/*
|--------------------------------------------------------------------------
| Regular Routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'PageController@index')->name('page_index');

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'users'], function () {
    Route::group(['namespace' => 'Auth'], function() {
        // Authentication Routes
        Route::get('login', 'LoginController@showLoginForm')->name('users_auth_login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('users_auth_logout');

        // Registration Routes
        Route::get('register', 'RegisterController@showRegistrationForm')->name('users_auth_register');
        Route::post('register', 'RegisterController@register');

        // Password Reset Routes
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('users_auth_reset');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('users_auth_email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });

    Route::get('profile/{slug}.{id}', 'UserController@show')->name('users_user_show');

    Route::group(['middleware' => ['auth']], function() {
        // Users Routes
        Route::get('account', 'UserController@index')->name('users_user_index');
        Route::put('account', 'UserController@update')->name('users_user_update');
    });
});

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function() {

    // Article Routes
    Route::get('/', 'ArticleController@index')
        ->name('blog_article_index');
    Route::get('/article/{slug}.{id}', 'ArticleController@show')
        ->name('blog_article_show');

    // Category Routes
    Route::get('/category/{slug}.{id}', 'CategoryController@show')
        ->name('blog_category_show');

    Route::group(['middleware' => ['auth']], function() {
        // Comment Routes
        Route::post('/comment/create', 'CommentController@create')
        ->name('blog_comment_create');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group([
        'namespace' => 'Admin',
        'prefix' => 'admin',
        'middleware' => ['auth', 'admin']
    ], function () {
    Route::get('/', 'PageController@index')->name('admin_page_index');
});
