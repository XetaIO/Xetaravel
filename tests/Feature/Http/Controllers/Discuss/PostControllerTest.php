<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Discuss;

use Tests\TestCase;
use Xetaravel\Models\DiscussPost;

class PostControllerTest extends TestCase
{
    public function test_show_post()
    {
        $conversation = DiscussPost::find(1)->conversation;

        $response = $this->get('/discuss/post/show/1');
        $response->assertRedirect(route(
            'discuss.conversation.show',
            [
                'slug' => $conversation->slug,
                'id' => $conversation->id,
                'page' => 1,
                '#post-' . 1
            ]
        ));
    }
}
