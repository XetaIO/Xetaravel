<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Discuss;

use Tests\TestCase;
use Xetaravel\Livewire\Discuss\Conversation;

class DiscussControllerTest extends TestCase
{
    public function test_show_conversations()
    {
        $response = $this->get('/discuss');
        $response->assertSeeLivewire(Conversation::class);
    }

    public function test_show_leaderboard()
    {
        $response = $this->get('/discuss/leaderboard');
        $response->assertSuccessful();
        $response->assertSee('Community Pillar');
    }
}
