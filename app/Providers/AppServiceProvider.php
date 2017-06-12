<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View
        View::addNamespace('Admin', base_path() . '/resources/views/Admin');
        View::addNamespace('Blog', base_path() . '/resources/views/Blog');
        View::addNamespace('Auth', base_path() . '/resources/views/Auth');
        View::addNamespace('Discuss', base_path() . '/resources/views/Discuss');

        // Pagination
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        // Blade
        Blade::directive('auth', function () {
            return "<?php if (Auth::check()): ?>";
        });
        Blade::directive('endauth', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('notauth', function () {
            return "<?php if (!Auth::check()): ?>";
        });
        Blade::directive('endnotauth', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
