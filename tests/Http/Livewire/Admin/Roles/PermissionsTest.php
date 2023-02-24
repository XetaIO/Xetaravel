<?php
namespace Tests\Http\Livewire\Admin;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Roles\Permissions;
use Xetaravel\Models\Permission;
use Xetaravel\Models\User;

class PermissionsTest extends TestCase
{
    /**
     * testPermissionsPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testPermissionsPageContainsLivewireComponent()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/role/permission')->assertSeeLivewire(Permissions::class);
    }

    /**
     * testPermissionsCreateModal method
     *
     * @return void
     */
    public function testPermissionsCreateModal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permissions::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    /**
     * testPermissionsCreateModalWithEditModelBefore method
     *
     * @return void
     */
    public function testPermissionsCreateModalWithEditModelBefore()
    {
        $this->actingAs(User::find(1));
        $model = Permission::find(1);

        Livewire::test(Permissions::class)
            ->call('edit', 1)
            ->assertSet('model', $model)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model', Permission::make())
            ;
    }

    /**
     * testPermissionsEditModal method
     *
     * @return void
     */
    public function testPermissionsEditModal()
    {
        $this->actingAs(User::find(1));
        $model = Permission::find(1);

        Livewire::test(Permissions::class)
            ->assertSet('model', Permission::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model', ucfirst($model));
    }

    /**
     * testPermissionsSaveNewModel method
     *
     * @return void
     */
    public function testPermissionsSaveNewModel()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Permissions::class)
            ->set('model.name', 'Test Permission')
            ->Set('model.slug', 'test.permission')
            ->set('model.description', 'Description of the permission')
            ->set('model.is_deletable', true)
            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Permission::orderBy('id', 'desc')->first();
            $this->assertSame('Test Permission', $last->name);
            $this->assertSame('test.permission', $last->slug);
            $this->assertSame('Description of the permission', $last->description);
            $this->assertSame(true, (boolean)$last->is_deletable);
    }

    /**
     * testPermissionsDeleteSelected method
     *
     * @return void
     */
    public function testPermissionsDeleteSelected()
    {
        $this->actingAs(User::find(1));
        $model = Permission::find(1);
        $model->is_deletable = true;
        $model->save();
        $this->assertTrue((boolean)$model->is_deletable);

        Livewire::test(Permissions::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> permissions has been deleted successfully !')
            ->assertHasNoErrors();
    }

    /**
     * testPermissionsDeleteSelectedNotDeletable method
     *
     * @return void
     */
    public function testPermissionsDeleteSelectedNotDeletable()
    {
        $this->actingAs(User::find(1));
        $model = Permission::find(1);
        $this->assertFalse((boolean)$model->is_deletable);

        Livewire::test(Permissions::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertNotEmitted('alert')
            ->assertHasNoErrors();
    }
}
