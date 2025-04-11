<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Blog;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_show_category()
    {
        $response = $this->get('/blog/category/laravel.1');

        $response->assertSuccessful();
    }

    public function test_category_not_found()
    {
        Toaster::fake();
        $response = $this->get('/blog/category/fake.3');

        Toaster::assertDispatched('This category does not exist or has been deleted !');
        $response->assertStatus(302);
        $response->assertRedirect('/blog');
    }
}
