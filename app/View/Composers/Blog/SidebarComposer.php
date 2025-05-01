<?php

declare(strict_types=1);

namespace Xetaravel\View\Composers\Blog;

use Illuminate\View\View;
use Xetaravel\Models\Repositories\ArticleRepository;
use Xetaravel\Models\Repositories\BlogCategoryRepository;
use Xetaravel\Models\Repositories\UserRepository;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $articles = ArticleRepository::sidebar();
        $categories = BlogCategoryRepository::sidebar();
        $users = UserRepository::sidebar();

        $view->with(['articles' => $articles, 'categories' => $categories, 'users' => $users]);
    }
}
