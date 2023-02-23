<?php
namespace Tests\Http\Livewire\Admin;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Roles\Roles;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

class RolesTest extends TestCase
{
    /**
     * testRolesPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testRolesPageContainsLivewireComponent()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/role/role')->assertSeeLivewire(Roles::class);
    }

    /**
     * testRolesCreateModal method
     *
     * @return void
     */
    public function testRolesCreateModal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Roles::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    /**
     * testRolesCreateModalWithEditModelBefore method
     *
     * @return void
     */
    public function testRolesCreateModalWithEditModelBefore()
    {
        $this->actingAs(User::find(1));
        $model = Role::find(1);

        Livewire::test(Roles::class)
            ->call('edit', 1)
            ->assertSet('permissionsSelected', $model->permissions->pluck('id')->toArray())
            ->assertSet('model', $model)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model', Role::make())
            ;
    }

    /**
     * testRolesEditModal method
     *
     * @return void
     */
    public function testRolesEditModal()
    {
        $this->actingAs(User::find(1));
        $model = Role::with(['permissions'])->find(1);

        Livewire::test(Roles::class)
            ->assertSet('model', Role::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model', ucfirst($model));
    }

    /**
     * testRolesSaveNewModel method
     *
     * @return void
     */
    public function testRolesSaveNewModel()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Roles::class)
            ->set('model.name', 'Test Role')
            ->Set('model.slug', 'test.role')
            ->set('model.level', 1)
            ->set('model.css', 'font-weight: bold;')
            ->set('permissionsSelected', [1, 2])
            ->set('model.description', 'Description of the role')
            ->set('model.is_deletable', true)
            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Role::orderBy('id', 'desc')->first();
            $this->assertSame('Test Role', $last->name);
            $this->assertSame('test.role', $last->slug);
            $this->assertSame(1, $last->level);
            $this->assertSame('font-weight: bold;', $last->css);
            $this->assertSame([1, 2], $last->permissions->pluck('id')->toArray());
            $this->assertSame('Description of the role', $last->description);
            $this->assertSame(true, (boolean)$last->is_deletable);
    }

    /**
     * testRolesDeleteSelected method
     *
     * @return void
     */
    public function testRolesDeleteSelected()
    {
        $this->actingAs(User::find(1));
        $model = Role::find(1);
        $model->is_deletable = true;
        $model->save();
        $this->assertTrue((boolean)$model->is_deletable);

        Livewire::test(Roles::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> roles has been deleted successfully !')
            ->assertHasNoErrors();
    }

    /**
     * testRolesDeleteSelectedNotDeletable method
     *
     * @return void
     */
    public function testRolesDeleteSelectedNotDeletable()
    {
        $this->actingAs(User::find(1));
        $model = Role::find(1);
        $this->assertFalse((boolean)$model->is_deletable);

        Livewire::test(Roles::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertNotEmitted('alert')
            ->assertHasNoErrors();
    }
}
