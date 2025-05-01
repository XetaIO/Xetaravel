<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Permission;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Permission\CreateRole;
use Xetaravel\Models\User;

class CreateRoleTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/role')
            ->assertSeeLivewire(CreateRole::class);
    }

    public function test_create_modal()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateRole::class)
            ->call('createPermission')
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateRole::class)
            ->set('form.name', '')
            ->set('form.color', 'no_hex')
            ->set('form.level', '')
            ->set('form.description', '')
            ->call('create')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.color' => 'hex_color',
                'form.level' => 'required',
                'form.permissions' => 'required',
            ]);
    }

    public function test_can_create_role()
    {
        Toaster::fake();

        Livewire::actingAs(User::find(1))
            ->test(CreateRole::class)
            ->set('form.name', 'Role')
            ->set('form.color', '#ffffff')
            ->set('form.level', 12)
            ->set('form.description', 'Description')
            ->set('form.permissions', [
                'access administration',
                'bypass login',
                'create blog article',
            ])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('roles', [
            'name' => 'Role',
            'color' => '#ffffff',
            'level' => 12,
            'description' => 'Description',
        ]);
        Toaster::assertDispatched('The role Role has been created successfully !');
    }
}
