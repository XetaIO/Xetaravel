<?php

declare(strict_types=1);

namespace Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_reset_form_success()
    {
        $response = $this->get('/auth/password/reset/123456');
        $response->assertSuccessful();
    }
}
