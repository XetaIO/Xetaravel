<?php
namespace Tests\Http\Controllers\Admin\Discuss;

use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\User;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
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
        $response = $this->get('/admin/discuss/category');
        $response->assertSuccessful();
    }
}
