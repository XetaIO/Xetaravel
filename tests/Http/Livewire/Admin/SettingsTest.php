<?php
namespace Tests\Http\Livewire\Admin;

use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Settings;
use Xetaravel\Models\Setting;
use Xetaravel\Models\User;

class SettingsTest extends TestCase
{
    /**
     * testSettingsPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testSettingsPageContainsLivewireComponent()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/settings')->assertSeeLivewire(Settings::class);
    }

    /**
     * testSettingsCreateModal method
     *
     * @return void
     */
    public function testSettingsCreateModal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Settings::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    /**
     * testSettingsCreateModalWithEditModelBefore method
     *
     * @return void
     */
    public function testSettingsCreateModalWithEditModelBefore()
    {
        $this->actingAs(User::find(1));
        $model = Setting::find(1);

        Livewire::test(Settings::class)
            ->call('edit', 1)
            ->assertSet('value', $model->value)
            ->assertSet('type', $model->type)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('value', '')
            ->assertSet('type', 'value_bool')
            ->assertSet('model', Setting::make())
            ;
    }

    /**
     * testSettingsEditModal method
     *
     * @return void
     */
    public function testSettingsEditModal()
    {
        $this->actingAs(User::find(1));
        $model = Setting::find(1);

        Livewire::test(Settings::class)
            ->assertSet('value', '')
            ->assertSet('type', 'value_bool')
            ->assertSet('model', Setting::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('type', $model->type)
            ->assertSet('value', $model->value)
            ->assertSet('model', $model)
            ;
    }

    /**
     * testSettingsGenerateSlug method
     *
     * @return void
     */
    public function testSettingsGenerateSlug()
    {
        $this->actingAs(User::find(1));
        $model = Setting::find(1);

        Livewire::test(Settings::class)
            ->call('edit', 1)
            ->assertSet('slug', Str::slug($model->name, '.'));
    }

    /**
     * testSettingsSaveNewModel method
     *
     * @return void
     */
    public function testSettingsSaveNewModel()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Settings::class)
            ->set('model.name', 'Test Setting')
            ->Set('slug', 'test.setting')
            ->set('value', 'Test value')
            ->set('type', 'value_str')
            ->set('model.description', 'Test description of setting')
            ->set('model.is_deletable', true)
            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Setting::orderBy('id', 'desc')->first();
            $this->assertSame('test.setting', $last->name);
            $this->assertSame('Test value', $last->value);
            $this->assertSame('value_str', $last->type);
            $this->assertSame('Test description of setting', $last->description);
            $this->assertSame(true, (boolean)$last->is_deletable);
    }

    /**
     * testSettingsDeleteSelected method
     *
     * @return void
     */
    public function testSettingsDeleteSelected()
    {
        $this->actingAs(User::find(1));
        $model = Setting::find(1);
        $model->is_deletable = true;
        $model->save();
        $this->assertTrue((boolean)$model->is_deletable);

        Livewire::test(Settings::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> settings has been deleted successfully !')
            ->assertHasNoErrors();
    }

    /**
     * testSettingsDeleteSelectedNotDeletable method
     *
     * @return void
     */
    public function testSettingsDeleteSelectedNotDeletable()
    {
        $this->actingAs(User::find(1));
        $model = Setting::find(1);
        $this->assertFalse((boolean)$model->is_deletable);

        Livewire::test(Settings::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertNotEmitted('alert')
            ->assertHasNoErrors();
    }
}
