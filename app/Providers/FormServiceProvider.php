<?php
namespace Xetaravel\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Collective Form
        Form::component('bsText', 'components.form.text', [
            'name',
            'label' => null,
            'value' => null,
            'attributes' => [],
            'labelClass' => 'form-control-label'
        ]);
        Form::component('bsEmail', 'components.form.email', [
            'name',
            'label' => null,
            'value' => null,
            'attributes' => []
        ]);
        Form::component('bsNumber', 'components.form.number', [
            'name',
            'label' => null,
            'value' => null,
            'attributes' => []
        ]);
        Form::component('bsTextarea', 'components.form.textarea', [
            'name',
            'label' => null,
            'value' => null,
            'attributes' => [],
            'labelClass' => 'form-control-label'
        ]);
        Form::component('bsPassword', 'components.form.password', ['name', 'label' => null, 'attributes' => []]);
        Form::component('bsCheckbox', 'components.form.checkbox', [
            'name',
            'value' => 1,
            'checked' => null,
            'label' => null,
            'attributes' => [],
            'labelClass' => 'form-control-label'
        ]);
        Form::component('bsRadio', 'components.form.radio', [
            'name',
            'value' => 1,
            'checked' => null,
            'label' => null,
            'attributes' => [],
            'labelClass' => 'form-control-label'
        ]);
        Form::component('bsInputGroup', 'components.form.input-group', [
            'name',
            'label' => null,
            'value' => null,
            'attributes' => []
        ]);
        Form::component('bsSelect', 'components.form.select', [
            'name',
            'list' => [],
            'label' => null,
            'selected' => null,
            'attributes' => [],
            'optionsAttributes' => [],
            'labelClass' => 'form-control-label'
        ]);
    }
}
