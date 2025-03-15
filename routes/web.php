<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Regular Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['display']], function () {
    Route::get('/', [Xetaravel\Http\Controllers\PageController::class, 'index'])
        ->name('page.index');
    Route::get('@me', [Xetaravel\Http\Controllers\PageController::class, 'aboutme'])
        ->name('page.aboutme');

    Route::get('terms', [Xetaravel\Http\Controllers\PageController::class, 'terms'])
        ->name('page.terms');

    Route::get('contact', [Xetaravel\Http\Controllers\PageController::class, 'showContact'])
        ->name('page.contact');
    Route::post('contact', [Xetaravel\Http\Controllers\PageController::class, 'contact']);

    Route::post('newsletter/subscribe', [Xetaravel\Http\Controllers\NewsletterController::class, 'store'])
        ->name('newsletter.subscribe');
    Route::get('newsletter/unsubscribe/{email}', [Xetaravel\Http\Controllers\NewsletterController::class, 'delete'])
        ->name('newsletter.unsubscribe');

    Route::get('download/{file}', [Xetaravel\Http\Controllers\DownloadsController::class, 'download'])
        ->name('downloads.show');
});

Route::group(['middleware' => ['auth', 'permission:show banished']], function () {
    Route::get('banished', 'PageController@banished')->name('page.banished');
});

/*
|--------------------------------------------------------------------------
| Authentication/Socialite Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth'
], function () {
    Route::get('{driver}/redirect', [Xetaravel\Http\Controllers\Auth\SocialiteController::class, 'redirectToProvider'])
        ->name('auth.driver.redirect');
    Route::get('{driver}/callback', [Xetaravel\Http\Controllers\Auth\SocialiteController::class, 'handleProviderCallback'])
        ->name('auth.driver.callback');
    Route::get('{driver}/register/form', [Xetaravel\Http\Controllers\Auth\SocialiteController::class, 'showRegistrationForm'])
        ->name('auth.driver.register');
    Route::post('{driver}/register/validate', [Xetaravel\Http\Controllers\Auth\SocialiteController::class, 'register'])
        ->name('auth.driver.register.validate');

    // Authentication Routes
    Route::get('login', [Xetaravel\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
        ->name('auth.login');
    Route::post('login', [Xetaravel\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('logout', [Xetaravel\Http\Controllers\Auth\LoginController::class, 'logout'])
        ->name('auth.logout');

    // Registration Routes
    Route::get('register', [Xetaravel\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])
        ->name('auth.register');
    Route::post('register', [Xetaravel\Http\Controllers\Auth\RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('password/reset', [Xetaravel\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('auth.password.request');
    Route::post('password/email', [Xetaravel\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('auth.password.email');
    Route::get('password/reset/{token}', [Xetaravel\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
        ->name('auth.password.reset');
    Route::post('password/reset', [Xetaravel\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
        ->name('auth.password.handlereset');

    // Email Verification Routes
    Route::get('email/verify/{hash}', [Xetaravel\Http\Controllers\Auth\VerificationController::class, 'show'])
        ->name('auth.verification.notice');
    Route::get('email/verify/{id}/{hash}', [Xetaravel\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->name('auth.verification.verify');
    Route::post('email/resend', [Xetaravel\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->name('auth.verification.resend');
});

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'users'], function () {

    Route::get('profile/@{slug}', [Xetaravel\Http\Controllers\UserController::class, 'show'])->name('users.user.show');
    Route::get('/', [Xetaravel\Http\Controllers\UserController::class, 'index'])->name('users.user.index');

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
    'middleware' => ['display']
], function () {

    // BlogArticle Routes
    Route::get('/', [Xetaravel\Http\Controllers\Blog\ArticleController::class, 'index'])
        ->name('blog.article.index');
    Route::get('article/{slug}.{id}', [Xetaravel\Http\Controllers\Blog\ArticleController::class, 'show'])
        ->name('blog.article.show');

    // BlogCategory Routes
    Route::get('category/{slug}.{id}', [Xetaravel\Http\Controllers\Blog\CategoryController::class, 'show'])
        ->name('blog.category.show');

    // BlogComment Routes
    Route::get('comment/show/{id}', [Xetaravel\Http\Controllers\Blog\CommentController::class, 'show'])
        ->name('blog.comment.show');

    Route::group(['middleware' => ['auth']], function () {
        // BlogComment Routes
        Route::post('comment/create', [Xetaravel\Http\Controllers\Blog\CommentController::class, 'create'])
            ->name('blog.comment.create');
        Route::delete('comment/delete/{id}', [Xetaravel\Http\Controllers\Blog\CommentController::class, 'delete'])
            ->name('blog.comment.delete');
        Route::put('comment/edit/{id}', [Xetaravel\Http\Controllers\Blog\CommentController::class, 'edit'])
            ->name('blog.comment.edit');
        Route::get('comment/edit-template/{id}', [Xetaravel\Http\Controllers\Blog\CommentController::class, 'editTemplate'])
            ->name('blog.comment.editTemplate');
    });
});
