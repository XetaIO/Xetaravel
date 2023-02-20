<?php
namespace Tests\Http\Controllers\Admin\Blog;

use Xetaravel\Models\Article;
use Xetaravel\Models\Category;
use Xetaravel\Models\Comment;
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
        $response = $this->get('/admin/blog/category');
        $response->assertSuccessful();
    }
}
