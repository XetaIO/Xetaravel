<?php
namespace Tests\Http\Livewire\Admin\Blog;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Blog\Categories;
use Xetaravel\Models\Category;
use Xetaravel\Models\User;

class CategoriesTest extends TestCase
{
    /**
     * testCategoriesPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testCategoriesPageContainsLivewireComponent()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/blog/category')->assertSeeLivewire(Categories::class);
    }

    /**
     * testCategoriesCreateModal method
     *
     * @return void
     */
    public function testCategoriesCreateModal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Categories::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    /**
     * testCategoriesCreateModalWithEditModelBefore method
     *
     * @return void
     */
    public function testCategoriesCreateModalWithEditModelBefore()
    {
        $this->actingAs(User::find(1));
        $model = Category::find(1);

        Livewire::test(Categories::class)
            ->call('edit', 1)
            ->assertSet('model', $model)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model', Category::make())
            ;
    }

    /**
     * testCategoriesEditModal method
     *
     * @return void
     */
    public function testCategoriesEditModal()
    {
        $this->actingAs(User::find(1));
        $model = Category::find(1);

        Livewire::test(Categories::class)
            ->assertSet('model', Category::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model', $model);
    }

    /**
     * testCategoriesSaveNewModel method
     *
     * @return void
     */
    public function testCategoriesSaveNewModel()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Categories::class)
            ->set('model.title', 'Test Category')
            ->Set('model.slug', 'test.category')
            ->set('model.description', 'Description of the category')
            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Category::orderBy('id', 'desc')->first();
            $this->assertSame('Test Category', $last->title);
            $this->assertSame('test.category', $last->slug);
            $this->assertSame('Description of the category', $last->description);
    }

    /**
     * testCategoriesDeleteSelected method
     *
     * @return void
     */
    public function testCategoriesDeleteSelected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Categories::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> categories has been deleted successfully !')
            ->assertHasNoErrors();
    }
}
