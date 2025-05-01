<?php

declare(strict_types=1);

namespace Xetaravel\View\Composers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\Repositories\DiscussCategoryRepository;

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
        $categories = DiscussCategoryRepository::sidebar();

        $view->with(['categories' => $categories]);
    }
}
