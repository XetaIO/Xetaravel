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

    /**
     * testShowCreateFormSuccess method
     *
     * @return void
     */
    public function testShowCreateFormSuccess()
    {
        $response = $this->get('/admin/discuss/category/create');
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
            'title' => 'My category',
            'color' => '#dddddd',
            'is_locked' => false,
            'description' => 'My awesome description.'
        ];

        $response = $this->post('/admin/discuss/category/create', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $category = DiscussCategory::where('title', $data['title'])->first();
        $this->assertSame($data['title'], $category->title);
        $this->assertSame('my-category', (string) $category->slug);
    }

    /**
     * testShowUpdateFormSuccess method
     *
     * @return void
     */
    public function testShowUpdateFormSuccess()
    {
        $response = $this->get('/admin/discuss/category/update/awesome-slug.1');
        $response->assertSuccessful();
    }

    /**
     * testShowUpdateFormCategoryNotFound method
     *
     * @return void
     */
    public function testShowUpdateFormCategoryNotFound()
    {
        $response = $this->get('/admin/discuss/category/update/eww-slug.1337');
        $response->assertStatus(404);
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $data = [
            'title' => 'My category',
            'color' => '#dddddd',
            'description' => 'My awesome description.'
        ];

        $response = $this->put('/admin/discuss/category/update/1', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $category = DiscussCategory::find(1);
        $this->assertSame($data['title'], $category->title);
        $this->assertSame('my-category', (string) $category->slug);
        $this->assertSame($data['color'], $category->color);
        $this->assertFalse((bool) $category->is_locked);
        $this->assertSame($data['description'], $category->description);
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $response = $this->delete('/admin/discuss/category/delete/1');
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertNull(DiscussCategory::find(1));
    }

    /**
     * testDeleteCategoryNotFound method
     *
     * @return void
     */
    public function testDeleteCategoryNotFound()
    {
        $response = $this->delete('/admin/discuss/category/delete/1337');
        $response->assertStatus(404);
    }
}
