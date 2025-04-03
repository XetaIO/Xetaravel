<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_categories()
    {
        $response = $this->get('/discuss/categories');
        $response->assertSuccessful();
    }
}
