<?php
namespace Tests\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Xetaravel\Models\User;

class UserControllerTest extends TestCase
{
    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/users');
        $response->assertSuccessful();
    }

    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testShowSuccess()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/users/profile/@admin');
        $response->assertSuccessful();
    }

    /**
     * testShowUserNotFound method
     *
     * @return void
     */
    public function testShowUserNotFound()
    {
        $response = $this->get('/users/profile/@admin1337');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testShowSettingsForm method
     *
     * @return void
     */
    public function testShowSettingsForm()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/users/settings');
        $response->assertSuccessful();
    }

    /**
     * testUpdateInvalidType method
     *
     * @return void
     */
    public function testUpdateInvalidType()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->put('/users/settings', ['type' => 'unknown']);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }

    /**
     * testUpdateEmailSuccess method
     *
     * @return void
     */
    public function testUpdateEmailSuccess()
    {
        $user = User::find(1);
        $this->be($user);
        $this->assertSame('admin@xeta.io', $user->email);

        $response = $this->put('/users/settings', ['type' => 'email', 'email' => 'newadmin@xeta.io']);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/users/settings');

        $user = User::find(1);
        $this->assertSame('newadmin@xeta.io', $user->email);
    }

    /**
     * testUpdateEmailAlreadyTakenFailed method
     *
     * @return void
     */
    public function testUpdateEmailAlreadyTakenFailed()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->put('/users/settings', ['type' => 'email', 'email' => 'admin@xeta.io']);
        $response->assertSessionHasErrors(['email']);
        $response->assertStatus(302);
    }

    /**
     * testUpdatePasswordSuccess method
     *
     * @return void
     */
    public function testUpdatePasswordSuccess()
    {
        $user = User::find(1);
        $this->be($user);
        $this->assertTrue(Hash::check('admin', $user->password));

        $response = $this->put('/users/settings', [
            'type' => 'password',
            'oldpassword' => 'admin',
            'password' => 'adminmodified',
            'password_confirmation' => 'adminmodified'
        ]);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/users/settings');

        $user = User::find(1);
        $this->assertTrue(Hash::check('adminmodified', $user->password));
    }

    /**
     * testUpdatePasswordNotMatchOldPasswordFailed method
     *
     * @return void
     */
    public function testUpdatePasswordNotMatchOldPasswordFailed()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->put('/users/settings', [
            'type' => 'password',
            'oldpassword' => 'NOT MATCH',
            'password' => 'adminmodified',
            'password_confirmation' => 'adminmodified'
        ]);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/users/settings');
    }

    /**
     * testUpdatePasswordNotMatchFailed method
     *
     * @return void
     */
    public function testUpdatePasswordNotMatchFailed()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->put('/users/settings', [
            'type' => 'password',
            'oldpassword' => 'admin',
            'password' => 'NOT MATCH',
            'password_confirmation' => 'adminmodified'
        ]);
        $response->assertSessionHasErrors(['password']);
        $response->assertStatus(302);
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->delete('/users/delete', ['password' => 'admin']);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testDeleteWrongPasswordFailed method
     *
     * @return void
     */
    public function testDeleteWrongPasswordFailed()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->delete('/users/delete', ['password' => 'WRONG PASSWORD']);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }
}
