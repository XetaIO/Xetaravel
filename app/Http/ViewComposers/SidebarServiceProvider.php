<?php
namespace Xetaravel\Http\ViewComposers;

use Xetaravel\Models\Article;
use Xetaravel\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('Blog::article._sidebar', function ($view) {
            $articles = Article::sidebar();
            $categories = Category::sidebar();

            $view->with(['articles' => $articles, 'categories' => $categories]);
        });
    }
}
