<?php
namespace App\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
    }
}
