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
                ->addClass('menu')
                ->add(
                    Link::toRoute('admin.page.index', '<i class="fa-solid fa-gauge"></i> Dashboard')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->setActiveFromRequest('/admin')
                ->setActiveClassOnLink();
        });

        Menu::macro('admin.blog', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('admin.blog.article.index', '<i class="fa-regular fa-newspaper"></i> Manage Articles')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->add(
                    Link::toRoute('admin.blog.category.index', '<i class="fa-solid fa-tags"></i> Manage Categories')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('admin.discuss', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('admin.discuss.category.index', '<i class="fa-solid fa-tags"></i> Manage Categories')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('admin.user', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('admin.user.user.index', '<i class="fa-solid fa-users"></i> Manage Users')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('admin.role', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('admin.role.role.index', '<i class="fa-solid fa-user-tie"></i> Manage Roles')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->add(
                    Link::toRoute(
                        'admin.role.permission.index',
                        '<i class="fa-solid fa-user-shield"></i> Manage Permissions'
                    )
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('admin.setting', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('admin.setting.index', '<i class="fa-solid fa-wrench"></i> Manage Settings')
                        ->addClass('rounded-[var(--rounded-btn)]')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });
    }
}
