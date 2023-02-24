<?php
namespace Tests\Http\Livewire\Discuss;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Discuss\Conversation;

class ConversationTest extends TestCase
{
    /**
     * testConversationPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testConversationPageContainsLivewireComponent()
    {
        $this->get('/discuss')->assertSeeLivewire(Conversation::class);
    }

    /**
     * testConversationWithSearchWithResult method
     *
     * @return void
     */
    public function testConversationWithSearchWithResult()
    {
        Livewire::withQueryParams(['s' => 'announcement'])
            ->test(Conversation::class)
            ->assertSet('search', 'announcement')
            ->assertDontSee('Maybe try with another word.');
    }

    /**
     * testConversationWithSearchNoRows method
     *
     * @return void
     */
    public function testConversationWithSearchNoRows()
    {
        Livewire::withQueryParams(['s' => 'xx'])
            ->test(Conversation::class)
            ->assertSet('search', 'xx')
            ->assertSee('Maybe try with another word.');
    }

    /**
     * testConversationWithSortFieldAllowed method
     *
     * @return void
     */
    public function testConversationWithSortFieldAllowed()
    {
        Livewire::test(Conversation::class)
            ->set('sortField', 'is_solved')
            ->assertSet('sortField', 'is_solved');
    }

    /**
     * testConversationWithSortFieldNotAllowed method
     *
     * @return void
     */
    public function testConversationWithSortFieldNotAllowed()
    {
        Livewire::test(Conversation::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    /**
     * testConversationWithSortFieldNotAllowedOnMount method
     *
     * @return void
     */
    public function testConversationWithSortFieldNotAllowedOnMount()
    {
        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Conversation::class)
            ->assertSet('sortField', 'created_at');
    }

    /**
     * testConversationWithCategoryAllowed method
     *
     * @return void
     */
    public function testConversationWithCategoryAllowed()
    {
        Livewire::withQueryParams(['c' => 1])
            ->test(Conversation::class)
            ->assertSet('category', 1);
    }

    /**
     * testConversationWithCategoryNotAllowed method
     *
     * @return void
     */
    public function testConversationWithCategoryNotAllowed()
    {
        Livewire::withQueryParams(['c' => 30])
            ->test(Conversation::class)
            ->assertSet('category', 0);
    }

    /**
     * testConversationWithSelectCategoryNotAllowed method
     *
     * @return void
     */
    public function testConversationWithSelectCategoryNotAllowed()
    {
        Livewire::test(Conversation::class)
            ->call('select', 30)
            ->assertSet('category', 0)
            ->assertSet('open', false); //Should close the modal
    }

    /**
     * testConversationWithLimitNotAllowed method
     *
     * @return void
     */
    public function testConversationWithLimitNotAllowed()
    {
        Livewire::test(Conversation::class)
            ->set('limit', 100)
            ->assertSet('limit', config('xetaravel.pagination.discuss.conversation_per_page'));
    }

    /**
     * testConversationWithLimitAllowed method
     *
     * @return void
     */
    public function testConversationWithLimitAllowed()
    {
        Livewire::test(Conversation::class)
            ->set('limit', 50)
            ->assertSet('limit', 50);
    }

    /**
     * testConversationToggleMenuOpen method
     *
     * @return void
     */
    public function testConversationToggleMenuOpen()
    {
        Livewire::test(Conversation::class)
            ->set('open', false)
            ->call('toggle')
            ->assertSet('open', true);
    }

    /**
     * testConversationToggleMenuFalse method
     *
     * @return void
     */
    public function testConversationToggleMenuFalse()
    {
        Livewire::test(Conversation::class)
            ->set('open', true)
            ->call('toggle')
            ->assertSet('open', false);
    }
}
