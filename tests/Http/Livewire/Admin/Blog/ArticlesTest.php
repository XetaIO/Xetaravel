<?php
namespace Tests\Http\Livewire\Admin\Blog;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Blog\Articles;
use Xetaravel\Models\User;

class ArticlesTest extends TestCase
{
    /**
     * testArticlesPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testArticlesPageContainsLivewireComponent()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/blog/article')->assertSeeLivewire(Articles::class);
    }

    /**
     * testCategoriesDeleteSelected method
     *
     * @return void
     */
    public function testCategoriesDeleteSelected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Articles::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> articles has been deleted successfully !')
            ->assertHasNoErrors();
    }
}
