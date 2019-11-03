<?php
namespace Tests\Http\Controllers\Admin\Role;

use Tests\TestCase;
use Xetaravel\Models\User;
use Xetaravel\Models\Permission;
use Xetaravel\Models\Role;

class PermissionControllerTest extends TestCase
{
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->be($user);
    }

    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/admin/role/permission');
        $response->assertSuccessful();
    }

    /**
     * testShowCreateFormSuccess method
     *
     * @return void
     */
    public function testShowCreateFormSuccess()
    {
        $response = $this->get('/admin/role/permission/create');
        $response->assertSuccessful();
    }

    /**
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $data = [
            'name' => 'Test Perm',
            'description' => 'Test description'
        ];
        $response = $this->post('/admin/role/permission/create', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $permission = Permission::where('name', $data['name'])->first();
        $this->assertSame($data['name'], $permission->name);
        $this->assertSame('test.perm', (string)$permission->slug);
        $this->assertSame($data['description'], $permission->description);
    }

    /**
     * testShowUpdateFormSuccess method
     *
     * @return void
     */
    public function testShowUpdateFormSuccess()
    {
        $response = $this->get('/admin/role/permission/update/1');
        $response->assertSuccessful();
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $data = [
            'name' => 'Test Perm',
            'description' => 'Test description'
        ];
        $response = $this->put('/admin/role/permission/update/1', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $permission = Permission::findOrFail(1);
        $this->assertSame($data['name'], $permission->name);
        $this->assertSame('test.perm', (string)$permission->slug);
        $this->assertSame($data['description'], $permission->description);
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $permission = Permission::create([
            'name' => 'Test Perm',
            'description' => 'Test description',
        ]);
        $role = Role::find(2);
        $role->permissions()->sync([$permission->id, 1, 2, 4]);

        $response = $this->delete("/admin/role/permission/delete/{$permission->id}");
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $this->assertTrue($role->permissions->contains('name', 'Manage Blog'));
        $this->assertFalse($role->permissions->contains('name', 'Test Perm'));
    }

    /**
     * testDeleteIsNotDeletableFailed method
     *
     * @return void
     */
    public function testDeleteIsNotDeletableFailed()
    {
        $response = $this->delete('/admin/role/permission/delete/1');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }
}
