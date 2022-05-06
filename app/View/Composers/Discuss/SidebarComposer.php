<?php
namespace Xetaravel\View\Composers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\Repositories\DiscussCategoryRepository;

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
        $categories = DiscussCategoryRepository::sidebar();

        $view->with(['categories' => $categories]);
    }
}
