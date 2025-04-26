<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Permission;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Permission\UpdatePermission;
use Xetaravel\Models\User;

class UpdatePermissionTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/permission')
            ->assertSeeLivewire(UpdatePermission::class);
    }

    public function test_modal_opens_and_form_is_populated(): void
    {
        $permission = Permission::find(1);

        $this->actingAs(User::find(1));

        Livewire::test(UpdatePermission::class)
            ->call('updatePermission', $permission->id)
            ->assertSet('form.name', $permission->name)
            ->assertSet('form.description', $permission->description)
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(UpdatePermission::class)
            ->call('updatePermission', 1)
            ->set('form.name', '')
            ->set('form.description', '')
            ->call('update')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.description' => 'required',
            ]);
    }

    public function test_permission_is_updated(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        Livewire::test(UpdatePermission::class)
            ->call('updatePermission', 1)
            ->set('form.name', 'Updated name')
            ->set('form.description', 'Updated description with more than ten characters.')
            ->call('update');

        $this->assertDatabaseHas('permissions', [
            'id' => 1,
            'name' => 'Updated name',
            'description' => 'Updated description with more than ten characters.',
        ]);
        Toaster::assertDispatched('Your permission has been updated successfully !');
    }
}
