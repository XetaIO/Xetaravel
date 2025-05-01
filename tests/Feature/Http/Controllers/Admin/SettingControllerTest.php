<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use Masmerise\Toaster\Toaster;
use Tests\TestCase;
use Xetaravel\Models\Setting;
use Xetaravel\Models\User;
use Xetaravel\Settings\Settings;

class SettingControllerTest extends TestCase
{
    public function test_Index_success()
    {
        $this->be(User::find(1));

        $response = $this->get(route('admin.setting.index'));

        $response->assertOk();
        $response->assertViewIs('Admin.setting.index');
        $response->assertViewHas('settings');
        $response->assertSee('Settings');

    }

    public function test_index_without_permission()
    {
        $this->be(User::find(3));

        $this->get(route('admin.setting.index'))
            ->assertStatus(302);
    }

    public function test_index_not_authenticated()
    {
        $this->get(route('admin.setting.index'))
            ->assertStatus(302);
    }

    public function test_update_settings_successfully(): void
    {
        Toaster::fake();
        $this->actingAs(User::find(1));

        Setting::factory()->create([
            'key' => 'site_name',
            'value' => 'OldValue',
        ]);

        $mock = $this->mock(Settings::class);
        $mock->shouldReceive('withoutContext')->once()->andReturnSelf();
        $mock->shouldReceive('remove')->once()->with('site_name');

        $response = $this->put(route('admin.setting.update'), [
            'site_name' => 'NewValue'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('settings', [
            'key' => 'site_name',
            'value' => serialize('NewValue')
        ]);
        Toaster::assertDispatched('All settings has been updated successfully !');
    }
}
