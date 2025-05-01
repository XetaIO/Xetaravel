<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Permission;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Permission\UpdateRole;
use Xetaravel\Models\User;

class UpdateRoleTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/role')
            ->assertSeeLivewire(UpdateRole::class);
    }

    public function test_modal_opens_and_form_is_populated(): void
    {
        $role = Role::find(1);

        $this->actingAs(User::find(1));

        Livewire::test(UpdateRole::class)
            ->call('updateRole', $role->id)
            ->assertSet('form.name', $role->name)
            ->assertSet('form.color', $role->color)
            ->assertSet('form.level', $role->level)
            ->assertSet('form.description', $role->description)
            ->assertSet('form.permissions', $role->permissions()->pluck('name')->toArray())
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(UpdateRole::class)
            ->call('updateRole', 3)
            ->set('form.name', '')
            ->set('form.color', 'no_hex')
            ->set('form.level', '')
            ->set('form.description', '')
            ->call('update')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.color' => 'hex_color',
                'form.level' => 'required'
            ]);
    }

    public function test_role_is_updated(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        Livewire::test(UpdateRole::class)
            ->call('updateRole', 3)
            ->set('form.name', 'Updated name')
            ->set('form.color', '#FF00FF')
            ->set('form.level', 68)
            ->set('form.description', 'Updated description with more than ten characters.')
            ->set('form.permissions', [
                'access administration',
                'bypass login',
                'create blog article',
            ])
            ->call('update');

        $this->assertDatabaseHas('roles', [
            'id' => 3,
            'name' => 'Updated name',
            'color' => '#FF00FF',
            'level' => 68,
            'description' => 'Updated description with more than ten characters.',
        ]);
        Toaster::assertDispatched('The role Updated name has been updated successfully !');
    }
}
