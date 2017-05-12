<?php
namespace Xetaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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

        // Pagination
        Paginator::defaultView('vendor.pagination.bootstrap-4');
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
