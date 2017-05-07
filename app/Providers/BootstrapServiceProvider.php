<?php
namespace Xetaravel\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\MenuFacade as Menu;
use Spatie\Menu\Laravel\Link;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Spatie Menu
        Menu::macro('userProfile', function () {
            return Menu::new()
                ->addClass('nav nav-menu flex-column')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('users.account.index', '<i class="fa fa-user"></i> Account')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.notification.index', '<i class="fa fa-bell-o"></i> Notifications')
                        ->addClass('nav-link')
                )
                ->setActiveFromRequest();
        });

        // Collective Form
        Form::component(
            'bsText',
            'components.form.text',
            ['name', 'label' => null, 'value' => null, 'attributes' => []]
        );
        Form::component(
            'bsEmail',
            'components.form.email',
            ['name', 'label' => null, 'value' => null, 'attributes' => []]
        );
        Form::component(
            'bsTextarea',
            'components.form.textarea',
            ['name', 'label' => null, 'value' => null, 'attributes' => []]
        );
        Form::component('bsPassword', 'components.form.password', ['name', 'label' => null, 'attributes' => []]);
        Form::component('bsCheckbox', 'components.form.checkbox', [
            'name',
            'value' => 1,
            'checked' => null,
            'label' => null,
            'attributes' => []
        ]);
        Form::component(
            'bsInputGroup',
            'components.form.input-group',
            ['name', 'label' => null, 'value' => null, 'attributes' => []]
        );
    }
}
