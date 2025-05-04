<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Badge;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Badge\CreateBadge;
use Xetaravel\Models\User;

class CreateBadgeTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/badge')
            ->assertSeeLivewire(CreateBadge::class);
    }

    public function test_create_modal()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateBadge::class)
            ->call('createBadge')
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(CreateBadge::class)
            ->set('form.name', '')
            ->set('form.icon', '')
            ->set('form.color', 'no_hex')
            ->set('form.type', '')
            ->set('form.rule', '')
            ->set('form.description', '')
            ->call('create')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.icon' => 'required',
                'form.color' => 'hex_color',
                'form.type' => 'required',
                'form.rule' => 'required'
            ]);
    }

    public function test_can_create_badge()
    {
        Toaster::fake();

        Livewire::actingAs(User::find(1))
            ->test(CreateBadge::class)
            ->set('form.name', 'Badge name')
            ->set('form.icon', 'fas-user')
            ->set('form.color', '#ffffff')
            ->set('form.type', 'onNewType')
            ->set('form.rule', 1)
            ->set('form.description', 'Description')
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('badges', [
            'name' => 'Badge name',
            'icon' => 'fas-user',
            'color' => '#ffffff',
            'type' => 'onNewType',
            'rule' => 1,
            'description' => 'Description',
        ]);
        Toaster::assertDispatched('The badge Badge name has been created successfully !');
    }
}
