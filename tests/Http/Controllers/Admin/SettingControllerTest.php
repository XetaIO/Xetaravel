<?php
namespace Tests\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Tests\TestCase;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\Setting;
use Xetaravel\Models\User;

class SettingControllerTest extends TestCase
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
        $response = $this->get('/admin/settings');
        $response->assertSuccessful();
    }
}
