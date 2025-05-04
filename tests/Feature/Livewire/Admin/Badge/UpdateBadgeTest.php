<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Badge;

use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Livewire\Admin\Badge\UpdateBadge;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;

class UpdateBadgeTest extends TestCase
{
    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/badge')
            ->assertSeeLivewire(UpdateBadge::class);
    }

    public function test_modal_opens_and_form_is_populated(): void
    {
        $badge = Badge::find(1);

        $this->actingAs(User::find(1));

        Livewire::test(UpdateBadge::class)
            ->call('updateBadge', $badge->id)
            ->assertSet('form.name', $badge->name)
            ->assertSet('form.icon', $badge->icon)
            ->assertSet('form.color', $badge->color)
            ->assertSet('form.type', $badge->type)
            ->assertSet('form.rule', $badge->rule)
            ->assertSet('form.description', $badge->description)
            ->assertSet('showModal', true);
    }

    public function test_validation_fails_with_missing_fields()
    {
        Livewire::actingAs(User::find(1))
            ->test(UpdateBadge::class)
            ->call('updateBadge', 1)
            ->set('form.name', '')
            ->set('form.icon', '')
            ->set('form.color', 'no_hex')
            ->set('form.type', '')
            ->set('form.rule', '')
            ->set('form.description', '')
            ->call('update')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.icon' => 'required',
                'form.color' => 'hex_color',
                'form.type' => 'required',
                'form.rule' => 'required'
            ]);
    }

    public function test_badge_is_updated(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        Livewire::test(UpdateBadge::class)
            ->call('updateBadge', 1)
            ->set('form.name', 'Updated name')
            ->set('form.icon', 'fas-user')
            ->set('form.color', '#FF00FF')
            ->set('form.type', 'onNewType')
            ->set('form.rule', 1)
            ->set('form.description', 'Updated description with more than ten characters.')
            ->call('update');

        $this->assertDatabaseHas('badges', [
            'id' => 1,
            'name' => 'Updated name',
            'icon' => 'fas-user',
            'color' => '#FF00FF',
            'type' => 'onNewType',
            'rule' => 1,
            'description' => 'Updated description with more than ten characters.',
        ]);
        Toaster::assertDispatched('The badge Updated name has been updated successfully !');
    }
}
