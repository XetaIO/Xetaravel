<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\User;

use Tests\TestCase;
use Xetaravel\Models\User;

class SettingControllerTest extends TestCase
{
    public function test_show_success()
    {
        $this->be(User::find(1));

        $response = $this->get('/users/profile/@admin');
        $response->assertSuccessful();
    }
}
