<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Permission;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Permission\CreatePermission;
use Xetaravel\Models\User;

class CreatePermissionTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/permission')
            ->assertSeeLivewire(CreatePermission::class);
    }

    public function test_create_modal()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreatePermission::class)
            ->call('createPermission')
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreatePermission::class)
            ->set('form.name', '')
            ->set('form.description', '')
            ->call('create')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.description' => 'required',
            ]);
    }

    public function test_can_create_permission()
    {
        Toaster::fake();

        Livewire::actingAs(User::find(1))
            ->test(CreatePermission::class)
            ->set('form.name', 'permission')
            ->set('form.description', 'Description')
            ->call('create');

        $this->assertDatabaseHas('permissions', [
            'name' => 'permission',
            'description' => 'Description',
        ]);
        Toaster::assertDispatched('Your permission has been created successfully !');
    }
}
