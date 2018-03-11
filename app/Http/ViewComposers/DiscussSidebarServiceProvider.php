<?php
namespace Xetaravel\Http\ViewComposers;

use Xetaravel\Models\Repositories\DiscussCategoryRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DiscussSidebarServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('Discuss::partials._sidebar', function ($view) {
            $categories = DiscussCategoryRepository::sidebar();

            $view->with(['categories' => $categories]);
        });
    }
}
