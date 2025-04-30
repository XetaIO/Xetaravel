<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use Tests\TestCase;
use Xetaravel\Models\User;

class PageControllerTest extends TestCase
{
    public function test_Index_success()
    {
        $this->be(User::find(1));

        $response = $this->get('/admin');
        $response->assertSuccessful();
    }

    public function test_index_without_permission()
    {
        $this->be(User::find(3));

        $response = $this->get('/admin');
        $response->assertStatus(302);
    }

    public function test_index_not_authenticated()
    {
        $response = $this->get('/admin');
        $response->assertStatus(302);
    }
}
