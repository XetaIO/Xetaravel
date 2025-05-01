<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Discuss;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Discuss\UpdateCategory;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\User;

class UpdateCategoryTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/discuss/category')
            ->assertSeeLivewire(UpdateCategory::class);
    }

    public function test_modal_opens_and_form_is_populated(): void
    {
        $category = DiscussCategory::find(1);

        $this->actingAs(User::find(1));

        Livewire::test(UpdateCategory::class)
            ->call('updateCategory', $category->id)
            ->assertSet('form.title', $category->title)
            ->assertSet('form.icon', $category->icon)
            ->assertSet('form.color', $category->color)
            ->assertSet('form.level', $category->level)
            ->assertSet('form.is_locked', $category->is_locked)
            ->assertSet('form.description', $category->description)
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(UpdateCategory::class)
            ->call('updateCategory', 1)
            ->set('form.title', '')
            ->set('form.icon', '')
            ->set('form.color', '')
            ->set('form.level', '')
            ->set('form.description', '')
            ->call('update')
            ->assertHasErrors([
                'form.title' => 'required',
                'form.icon' => 'required',
                'form.color' => 'required',
                'form.level' => 'required',
                'form.description' => 'required',
            ]);
    }

    public function test_category_is_updated(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        Livewire::test(UpdateCategory::class)
            ->call('updateCategory', 1)
            ->set('form.title', 'Updated title')
            ->set('form.icon', 'fas-search')
            ->set('form.color', '#DDDDDD')
            ->set('form.level', 10)
            ->set('form.is_locked', true)
            ->set('form.description', 'Updated description with more than ten characters.')
            ->call('update');

        $this->assertDatabaseHas('discuss_categories', [
            'id' => 1,
            'title' => 'Updated title',
            'icon' => 'fas-search',
            'color' => '#DDDDDD',
            'level' => 10,
            'is_locked' => true,
            'description' => 'Updated description with more than ten characters.',
        ]);
        Toaster::assertDispatched('Your category has been updated successfully !');
    }
}
