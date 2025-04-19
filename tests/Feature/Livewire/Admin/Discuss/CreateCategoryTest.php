<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Discuss;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Discuss\CreateCategory;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\User;

class CreateCategoryTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/discuss/category')
            ->assertSeeLivewire(CreateCategory::class);
    }

    public function test_create_modal()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateCategory::class)
            ->call('createCategory')
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateCategory::class)
            ->set('form.title', '')
            ->set('form.icon', '')
            ->set('form.color', '')
            ->set('form.level', '')
            ->set('form.description', '')
            ->call('create')
            ->assertHasErrors([
                'form.title' => 'required',
                'form.icon' => 'required',
                'form.color' => 'required',
                'form.level' => 'required',
                'form.description' => 'required',
            ]);
    }

    public function test_can_create_category()
    {
        Toaster::fake();

        Livewire::actingAs(User::find(1))
            ->test(CreateCategory::class)
            ->set('form.title', 'Z Category')
            ->set('form.icon', 'fas-search')
            ->set('form.color', '#DDDDDD')
            ->set('form.level', 6)
            ->set('form.description', 'Description')
            ->call('create');

        $category = DiscussCategory::where('title', 'Z Category')->first();
        $this->assertNotNull($category);
        Toaster::assertDispatched('Your category has been created successfully !');
    }
}
