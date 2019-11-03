<?php
namespace Tests\Http\Controllers\Admin\Role;

use Tests\TestCase;
use Xetaravel\Models\User;
use Xetaravel\Models\Role;

class RoleControllerTest extends TestCase
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
        $response = $this->get('/admin/role/role');
        $response->assertSuccessful();
    }

    /**
     * testShowCreateFormSuccess method
     *
     * @return void
     */
    public function testShowCreateFormSuccess()
    {
        $response = $this->get('/admin/role/role/create');
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
            'name' => 'Test',
            'css' => 'font-weight: bold;',
            'level' => 1,
            'description' => 'Test description',
            'permissions' => [
                1,
                2
            ]
        ];
        $response = $this->post('/admin/role/role/create', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $role = Role::where('name', $data['name'])->first();
        $this->assertSame($data['name'], $role->name);
        $this->assertSame('test', (string)$role->slug);
        $this->assertSame($data['css'], $role->css);
        $this->assertSame($data['level'], $role->level);
        $this->assertSame($data['description'], $role->description);
        $this->assertSame($data['permissions'], $role->permissions->pluck('id')->toArray());
    }

    /**
     * testShowUpdateFormSuccess method
     *
     * @return void
     */
    public function testShowUpdateFormSuccess()
    {
        $response = $this->get('/admin/role/role/update/1');
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
            'name' => 'Test',
            'css' => 'font-weight: bold;',
            'level' => 1,
            'description' => 'Test description',
            'permissions' => [
                1,
                2
            ]
        ];
        $response = $this->put('/admin/role/role/update/1', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $role = Role::findOrFail(1);
        $this->assertSame($data['name'], $role->name);
        $this->assertSame('test', (string)$role->slug);
        $this->assertSame($data['css'], $role->css);
        $this->assertSame($data['level'], $role->level);
        $this->assertSame($data['description'], $role->description);
        $this->assertSame($data['permissions'], $role->permissions->pluck('id')->toArray());
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $role = Role::create([
            'name' => 'test',
            'level' => 0,
            'permissions' => [
                1,
                2
            ]
        ]);
        $editor = User::find(2);
        $editor->roles()->sync($role);

        $banished = User::find(4);
        $banished->roles()->sync($role, false);

        $response = $this->delete("/admin/role/role/delete/{$role->id}");
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $this->assertTrue($banished->roles->contains('name', 'Banished'));
        $this->assertFalse($banished->roles->contains('name', 'User'));

        $this->assertTrue($editor->roles->contains('name', 'User'));
        $this->assertFalse($editor->roles->contains('name', 'Editor'));
    }

    /**
     * testDeleteIsNotDeletableFailed method
     *
     * @return void
     */
    public function testDeleteIsNotDeletableFailed()
    {
        $response = $this->delete('/admin/role/role/delete/1');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }
}
