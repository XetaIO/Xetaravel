<?php
namespace Tests\Http\Controllers\Admin\Role;

use Tests\TestCase;
use Xetaravel\Models\User;

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
}
