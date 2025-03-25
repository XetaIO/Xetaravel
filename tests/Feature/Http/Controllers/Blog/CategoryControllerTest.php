<?php

declare(strict_types=1);

namespace Http\Controllers\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Blog\Comment;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

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
