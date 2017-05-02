<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\User;
use Tests\TestCase;

class AccountControllerTest extends TestCase
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
        
        $response = $this->get('/users/account');
        $response->assertSuccessful();
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $user = User::find(1);
        $this->be($user);
        $this->assertTrue(empty($user->first_name));
        $oldAvatarUrl = $user->avatar_small;

        $file = new \Illuminate\Http\UploadedFile(
            base_path('tests/storage/tmp_avatar.png'),
            'tmp_avatar.png',
            24988,
            'image/png',
            null,
            true
        );
        
        $data = [
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'facebook' => 'Jhon_Doe',
            'twitter' => 'Doe_Jhon',
            'biography' => '<p>Jhon Doe</p>',
            'signature' => '<p>Doe Jhon</p>',
            'avatar' => $file
        ];
        $response = $this->put('/users/account', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        $user = User::find(1);
        $this->assertNotSame($oldAvatarUrl, $user->avatar_small, 'The path should not be the same.');
        $this->assertSame('Jhon', $user->first_name);
        $this->assertSame('Doe', $user->last_name);
        $this->assertSame('Jhon_Doe', $user->facebook);
        $this->assertSame('Doe_Jhon', $user->twitter);
        $this->assertSame('<p>Jhon Doe</p>', $user->biography);
        $this->assertSame('<p>Doe Jhon</p>', $user->signature);
    }
}
