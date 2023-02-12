<?php
namespace Xetaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Link;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::macro('user.profile', function () {
            return Menu::new()
                ->addClass('menu border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700')
                ->setAttribute('role', 'list')
                ->add(
                    Link::toRoute('users.account.index', '<i class="fa-solid fa-user-pen"></i> Account')
                )
                ->add(
                    Link::toRoute('users.notification.index', '<i class="fa-solid fa-user-tag"></i> Notifications')
                )
                ->add(
                    Link::toRoute('users.user.settings', '<i class="fa-solid fa-user-gear"></i> Settings')
                )
                ->add(
                    Link::toRoute('users.security.index', '<i class="fa-solid fa-user-shield"></i> Security')
                )
                ->setActiveClass('bordered')
                ->setActiveFromRequest()
                ->each(function (Link $link) {
                    if (!$link->isActive()) {
                        $link->addParentClass('hover-bordered');
                    }
                });
        });

        // Administration
        Menu::macro('admin.administration', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.page.index', '<i class="fa fa-dashboard"></i> Dashboard')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest('/admin');
        });

        Menu::macro('admin.blog', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.blog.article.index', '<i class="fa fa-newspaper-o"></i> Manage Articles')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->add(
                    Link::toRoute('admin.blog.category.index', '<i class="fa fa-tags"></i> Manage Categories')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });

        Menu::macro('admin.discuss', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.discuss.category.index', '<i class="fa fa-tags"></i> Manage Categories')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });

        Menu::macro('admin.user', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.user.user.index', '<i class="fa fa-users"></i> Manage Users')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });

        Menu::macro('admin.role', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.role.role.index', '<i class="fa fa-user-circle-o"></i> Manage Roles')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->add(
                    Link::toRoute('admin.role.permission.index', '<i class="fa fa-wrench"></i> Manage Permissions')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });

        Menu::macro('admin.setting', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.setting.index', '<i class="fa fa-cogs"></i> Manage Settings')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });
    }
}
