<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use Tests\TestCase;
use Xetaravel\Models\User;

class RedirectIfBanishedTest extends TestCase
{
    public function test_non_authenticated_users_are_not_redirected()
    {
        $this->get('/discuss')
            ->assertOk();
    }

    public function test_authenticated_non_banished_user_can_access()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('/discuss')
            ->assertOk();
    }

    public function test_banished_user_is_redirected_to_banished_page()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $this->get('/discuss')
            ->assertRedirect(route('page.banished'));
    }

    public function test_banished_user_can_access_banished_page()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $this->get('/banished')
            ->assertOk()
            ->assertSee('banished');
    }
}
