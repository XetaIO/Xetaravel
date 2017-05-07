<?php
namespace Xetaravel\Http\ViewComposers;

use Xetaravel\Models\Repositories\ArticleRepository;
use Xetaravel\Models\Repositories\CategoryRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BlogSidebarServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.blog._sidebar', function ($view) {
            $articles = ArticleRepository::sidebar();
            $categories = CategoryRepository::sidebar();

            $view->with(['articles' => $articles, 'categories' => $categories]);
        });
    }
}
