<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Xetaravel\Models\DiscussPost;

class ConversationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_post()
    {
        $conversation = DiscussPost::find(1)->conversation;

        $response = $this->get(route(
            'discuss.conversation.show',
            [
                'slug' => $conversation->slug,
                'id' => $conversation->id
            ]
        ));
        $response->assertSuccessful();
        $response->assertViewIs('Discuss.conversation.show');
    }
}
