<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\User;

use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\User\UpdateUser;
use Xetaravel\Models\User;

class UpdateUserTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/user')
            ->assertSeeLivewire(UpdateUser::class);
    }

    public function test_modal_opens_and_form_is_populated(): void
    {
        $user = User::find(1);

        $this->actingAs($user);

        Livewire::test(UpdateUser::class)
            ->call('updateUser', $user->id)
            ->assertSet('form.username', $user->username)
            ->assertSet('form.email', $user->email)
            ->assertSet('form.first_name', $user->first_name)
            ->assertSet('form.last_name', $user->last_name)
            ->assertSet('form.roles', $user->roles()->pluck('name')->toArray())
            ->assertSet('form.permissions', $user->permissions()->pluck('name')->toArray())
            ->assertSet('form.can_bypass', $user->hasPermissionTo('bypass login'))
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        $user = User::find(1);
        Livewire::actingAs($user)
            ->test(UpdateUser::class)
            ->call('updateUser', $user->id)
            ->set('form.username', '') // missing
            ->set('form.email', 'not-an-email') // invalid
            ->call('update')
            ->assertHasErrors([
                'form.username',
                'form.email'
            ]);
    }

    public function test_update_user()
    {
        $user = User::find(2);
        $role = Role::create(['name' => 'editor']);
        $permission = Permission::create(['name' => 'edit articles']);

        $this->actingAs(User::find(1));
        Livewire::test(UpdateUser::class)
            ->call('updateUser', $user->id)
            ->set('form.username', 'newusername')
            ->set('form.email', 'new@example.com')
            ->set('form.first_name', 'John')
            ->set('form.last_name', 'Doe')
            ->set('form.twitter', 'John')
            ->set('form.facebook', 'Doe')
            ->set('form.roles', ['editor'])
            ->set('form.permissions', ['edit articles'])
            ->set('form.can_bypass', true)
            ->call('update');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'newusername',
            'email' => 'new@example.com'
        ]);

        $this->assertDatabaseHas('accounts', [
            'user_id' => $user->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'twitter' => 'John',
            'facebook' => 'Doe',
        ]);

        $this->assertTrue($user->fresh()->hasRole('editor'));
        $this->assertTrue($user->fresh()->hasPermissionTo('edit articles'));
        $this->assertTrue($user->fresh()->hasPermissionTo('bypass login'));
    }
}
