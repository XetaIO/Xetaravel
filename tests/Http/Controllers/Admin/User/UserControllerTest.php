<?php
namespace Tests\Http\Controllers\Admin\User;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Xetaravel\Models\User;

class UserControllerTest extends TestCase
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
        $response = $this->get('/admin/user');
        $response->assertSuccessful();
    }

    /**
     * testSearchSuccess method
     *
     * @return void
     */
    public function testSearchSuccess()
    {
        $response = $this->get('/admin/user/search?search=admin&type=username');
        $response->assertSuccessful();
        $response->assertSee('admin@xeta.io');

        $response = $this->get('/admin/user/search?search=admin&type=email');
        $response->assertSuccessful();
        $response->assertSee('admin@xeta.io');

        $response = $this->get('/admin/user/search?search=127&type=register_ip');
        $response->assertSuccessful();
        $response->assertSee('admin@xeta.io');

        $response = $this->get('/admin/user/search?search=127&type=last_login_ip');
        $response->assertSuccessful();
        $response->assertSee('admin@xeta.io');

        $response = $this->get('/admin/user/search?search=admin&type=unknown');
        $response->assertSuccessful();
        $response->assertSee('admin@xeta.io');
    }

    /**
     * testShowUpdateFormSuccess method
     *
     * @return void
     */
    public function testShowUpdateFormSuccess()
    {
        $response = $this->get('/admin/user/update/admin.1');
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
            'username' => 'Test',
            'email' => 'test@xeta.io',
            'account' => [
                'first_name' => 'test first',
                'last_name' => 'test last',
                'facebook' => 'TestFB',
                'twitter' => 'TestTW',
                'biography' => '<p>My test biography</p>',
                'signature' => '<p>My test signature</p>'
            ],
            'roles' => [
                1,
                2
            ]
        ];
        $response = $this->put('/admin/user/update/1', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $user = User::findOrFail(1);
        $this->assertSame($data['username'], $user->username);
        $this->assertSame('test', (string)$user->slug);
        $this->assertSame($data['email'], $user->email);
        $this->assertSame($data['account']['first_name'], $user->first_name);
        $this->assertSame($data['account']['last_name'], $user->last_name);
        $this->assertSame($data['account']['facebook'], $user->facebook);
        $this->assertSame($data['account']['twitter'], $user->twitter);
        $this->assertSame($data['account']['biography'], $user->biography);
        $this->assertSame($data['account']['signature'], $user->signature);
        $this->assertSame($data['roles'], $user->roles->pluck('id')->toArray());
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->assertNotNull(User::find(2));

        $response = $this->delete('/admin/user/delete/2', ['password' => 'admin']);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $this->assertNull(User::find(2), 'The user must be deleted');
    }

    /**
     * testDeleteWrongPasswordFailed method
     *
     * @return void
     */
    public function testDeleteWrongPasswordFailed()
    {
        $response = $this->delete('/admin/user/delete/2', ['password' => 'WRONG PASSWORD']);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }

    /**
     * testDeleteAvatarSuccess method
     *
     * @return void
     */
    public function testDeleteAvatarSuccess()
    {
        $old = User::find(1)->avatar_small;

        $response = $this->delete('/admin/user/deleteAvatar/1');
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $this->assertNotSame($old, User::find(1)->avatar_small, 'The path should not be the same.');
    }
}
