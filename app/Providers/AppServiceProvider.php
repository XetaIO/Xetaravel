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
        $this->app['view']->addNamespace('Admin', base_path() . '/resources/views/Admin');
        $this->app['view']->addNamespace('Blog', base_path() . '/resources/views/Blog');

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
