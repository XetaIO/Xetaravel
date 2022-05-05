<?php
namespace Xetaravel\View\Composers\Blog;

use Illuminate\View\View;
use Xetaravel\Models\Repositories\ArticleRepository;
use Xetaravel\Models\Repositories\CategoryRepository;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $articles = ArticleRepository::sidebar();
        $categories = CategoryRepository::sidebar();

        $view->with(['articles' => $articles, 'categories' => $categories]);
    }
}
