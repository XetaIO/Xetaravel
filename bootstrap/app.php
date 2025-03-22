<?php

declare(strict_types=1);

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('web')
                ->group(function () {
                    require base_path('routes/web.php');
                    require base_path('routes/admin.php');
                    require base_path('routes/discuss.php');
                });
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            Xetaio\IpTraceable\Http\Middleware\IpTraceable::class
        ]);

        $middleware->alias([
            'auth' => Xetaravel\Http\Middleware\Authenticate::class,
            'discuss.maintenance' => Xetaravel\Http\Middleware\DiscussMaintenance::class,
            'display' => Xetaravel\Http\Middleware\EnableDisplayScopeMiddleware::class,

            // Packages Middleware
            'role' => Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Exception $e) {
            // Error 404 model not found
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return Redirect::route('page.index')
                    ->with('toasts', [[
                        'type' => 'error',
                        'duration' => 4000,
                        'message' => "This data does not exist or has been deleted!"
                    ]]);
            };

            // Error 419 csrf token expiration error
            if ($e->getPrevious() instanceof TokenMismatchException) {
                return Redirect::back()
                    ->error("It took you too long to validate the form! It's time for a coffee!");
            };

            // Error 403 Access unauthorized
            if ($e->getPrevious() instanceof AuthorizationException) {
                if (Auth::check() && Auth::user()->hasRole('banished')) {
                    return redirect()
                        ->route('page.banished');
                }

                return Redirect::route('page.index')
                    ->error("You are not authorized to access this page!");
            }
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        // Leaderboard Update
        $schedule->command('leaderboard:update')->weekly()->runInBackground();
    })->create();
