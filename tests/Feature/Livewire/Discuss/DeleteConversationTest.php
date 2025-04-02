<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Discuss;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Discuss\DeleteConversation;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussUser;
use Xetaravel\Models\User;

class DeleteConversationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_delete()
    {
        Toaster::fake();
        $old = DiscussConversation::find(1);

        Livewire::actingAs(User::find(1))
            ->test(DeleteConversation::class, ['discussConversation' => $old])
            ->call('deleteConversation')
            ->assertSet('showModal', true)

            ->call('delete')
            ->assertHasNoErrors();

        $this->assertNull(DiscussConversation::find(1));
        $this->assertTrue(DiscussPost::where('conversation_id', 1)->get()->isEmpty());
        $this->assertTrue(DiscussUser::where('conversation_id', 1)->get()->isEmpty());
        $this->assertTrue(DiscussConversation::whereHas('discussLogs', function ($q) {
            $q->where('loggable_id', '=', 1);
        })->get()->isEmpty());

        Toaster::assertDispatched('This discussion has been deleted successfully !');
    }
}
