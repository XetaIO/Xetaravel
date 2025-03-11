<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Regular Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['display']], function () {
    Route::get('/', [Xetaravel\Http\Controllers\PageController::class, 'index'])->name('page.index');
    Route::get('@me', 'PageController@aboutme')->name('page.aboutme');

    Route::get('terms', 'PageController@terms')->name('page.terms');

    Route::get('contact', 'PageController@showContact')->name('page.contact');
    Route::post('contact', 'PageController@contact');

    Route::post('newsletter/subscribe', 'NewsletterController@store')->name('newsletter.subscribe');
    Route::get('newsletter/unsubscribe/{email}', 'NewsletterController@delete')->name('newsletter.unsubscribe');

    Route::get('download/{file}', 'DownloadsController@download')->name('downloads.show');
});

Route::group(['middleware' => ['auth', 'permission:show banished']], function () {
    Route::get('banished', 'PageController@banished')->name('page.banished');
});

/*
|--------------------------------------------------------------------------
| Socialite Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth',
    'middleware' => 'permission:access.site,allowGuest'
], function () {
    Route::get('{driver}/redirect', 'SocialiteController@redirectToProvider')
        ->name('auth.driver.redirect');
    Route::get('{driver}/callback', 'SocialiteController@handleProviderCallback')
        ->name('auth.driver.callback');
    Route::get('{driver}/register/form', 'SocialiteController@showRegistrationForm')
        ->name('auth.driver.register');
    Route::post('{driver}/register/validate', 'SocialiteController@register')
        ->name('auth.driver.register.validate');
});

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'users', 'middleware' => ['permission:access.site,allowGuest']], function () {

    Route::get('profile/@{slug}', 'UserController@show')->name('users.user.show');
    Route::get('/', 'UserController@index')->name('users.user.index');

    // Auth Namespace
    Route::group(['namespace' => 'Auth'], function () {
        // Authentication Routes
        Route::get('login', 'LoginController@showLoginForm')->name('users.auth.login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('users.auth.logout');

        // Registration Routes
        Route::get('register', 'RegisterController@showRegistrationForm')->name('users.auth.register');
        Route::post('register', 'RegisterController@register');

        // Password Reset Routes
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')
            ->name('users.auth.password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
            ->name('users.auth.password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
            ->name('users.auth.password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')
            ->name('users.auth.password.handlereset');

        // Email Verification Routes
        Route::get('email/verify/{hash}', 'VerificationController@show')
            ->name('users.auth.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')
            ->name('users.auth.verification.verify');
        Route::post('email/resend', 'VerificationController@resend')
            ->name('users.auth.verification.resend');
    });

    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {
        // User Routes
        Route::get('settings', 'UserController@showSettingsForm')->name('users.user.settings');
        Route::put('settings', 'UserController@update');
        Route::delete('delete', 'UserController@delete')->name('users.user.delete');

        // Account Routes
        Route::get('account', 'AccountController@index')->name('users.account.index');
        Route::put('account', 'AccountController@update')->name('users.account.update');

        // Notification Routes
        Route::get('notification', 'NotificationController@index')
            ->name('users.notification.index');
        Route::post('notification/markAsRead', 'NotificationController@markAsRead')
            ->name('users.notification.markasread');
        Route::post('notification/markAllAsRead', 'NotificationController@markAllAsRead')
            ->name('users.notification.markallasread');
        Route::delete('notification/delete/{slug?}', 'NotificationController@delete')
            ->name('users.notification.delete');

        // Security Routes
        Route::get('security', 'SecurityController@index')->name('users.security.index');
    });
});

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'namespace' => 'Blog',
    'prefix' => 'blog',
    'middleware' => ['permission:access.site,allowGuest', 'display']
], function () {

    // BlogArticle Routes
    Route::get('/', 'ArticleController@index')
        ->name('blog.article.index');
    Route::get('article/{slug}.{id}', 'ArticleController@show')
        ->name('blog.article.show');

    // BlogCategory Routes
    Route::get('category/{slug}.{id}', 'CategoryController@show')
        ->name('blog.category.show');

    // BlogComment Routes
    Route::get('comment/show/{id}', 'CommentController@show')
        ->name('blog.comment.show');

    Route::group(['middleware' => ['auth']], function () {
        // BlogComment Routes
        Route::post('comment/create', 'CommentController@create')
            ->name('blog.comment.create');
        Route::delete('comment/delete/{id}', 'CommentController@delete')
            ->name('blog.comment.delete');
        Route::put('comment/edit/{id}', 'CommentController@edit')
            ->name('blog.comment.edit');
        Route::get('comment/edit-template/{id}', 'CommentController@editTemplate')
            ->name('blog.comment.editTemplate');
    });
});
