<?php
namespace Tests\Http\Livewire\Admin\Discuss;

use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Discuss\Categories;
use Xetaravel\Models\DiscussCategory;
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
        $this->get('/admin/discuss/category')->assertSeeLivewire(Categories::class);
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
        $model = DiscussCategory::find(1);

        Livewire::test(Categories::class)
            ->call('edit', 1)
            ->assertSet('model', $model)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model', DiscussCategory::make())
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
        $model = DiscussCategory::find(1);

        Livewire::test(Categories::class)
            ->assertSet('model', DiscussCategory::make())

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
            ->Set('model.icon', 'fa-solid fa-pencil')
            ->Set('model.color', '#00ffff')
            ->Set('model.level', 1)
            ->set('model.description', 'Description of the category')
            ->set('model.is_locked', true)
            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = DiscussCategory::orderBy('id', 'desc')->first();
            $this->assertSame('Test Category', $last->title);
            $this->assertSame('test.category', $last->slug);
            $this->assertSame('fa-solid fa-pencil', $last->icon);
            $this->assertSame('#00ffff', $last->color);
            $this->assertSame(1, $last->level);
            $this->assertSame('Description of the category', $last->description);
            $this->assertSame(true, (boolean)$last->is_locked);
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
