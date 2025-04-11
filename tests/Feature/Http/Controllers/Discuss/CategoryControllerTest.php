<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Discuss;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_show_categories()
    {
        $response = $this->get('/discuss/categories');
        $response->assertSuccessful();
    }
}
