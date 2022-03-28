<?php
namespace Tests\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Tests\TestCase;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\Setting;
use Xetaravel\Models\User;

class SettingControllerTest extends TestCase
{
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->be($user);
    }

    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/admin/settings');
        $response->assertSuccessful();
    }

    /**
     * testShowCreateFormSuccess method
     *
     * @return void
     */
    public function testShowCreateFormSuccess()
    {
        $response = $this->get('/admin/settings/create');
        $response->assertSuccessful();
    }

    /**
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $data = [
            'name' => 'Test Setting',
            'value' => 15,
            'type' => 'value_int',
            'description' => 'Test description',
            'is_deletable' => 'on'
        ];
        $response = $this->post('/admin/settings/create', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $setting = Setting::where('name', Str::slug($data['name'], '.'))->first();
        $this->assertSame(Str::slug($data['name'], '.'), $setting->name);
        $this->assertSame($data['value'], $setting->value_int);
        $this->assertNull($setting->value_str);
        $this->assertNull($setting->value_bool);
        $this->assertSame($data['description'], $setting->description);
        $this->assertTrue((bool) $setting->is_deletable);
    }

    /**
     * testShowUpdateFormSuccess method
     *
     * @return void
     */
    public function testShowUpdateFormSuccess()
    {
        $response = $this->get('/admin/settings/update/1');
        $response->assertSuccessful();
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $data = [
            'name' => 'Test Setting2',
            'value' => 'This text is a test.',
            'type' => 'value_str',
            'description' => 'Test description edit'
        ];
        $response = $this->put('/admin/settings/update/1', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $setting = Setting::findOrFail(1);
        $this->assertSame(Str::slug($data['name'], '.'), $setting->name);
        $this->assertSame($data['value'], $setting->value_str);
        $this->assertNull($setting->value_int);
        $this->assertNull($setting->value_bool);
        $this->assertSame($data['description'], $setting->description);
        $this->assertSame($data['description'], $setting->description);
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $setting = SettingRepository::create([
            'name' => 'Test Setting',
            'value' => 15,
            'type' => 'value_int',
            'description' => 'Test description',
            'is_deletable' => 'on'
        ]);

        $response = $this->delete("/admin/settings/delete/{$setting->id}");
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    /**
     * testDeleteIsNotDeletableFailed method
     *
     * @return void
     */
    public function testDeleteIsNotDeletableFailed()
    {
        $response = $this->delete('/admin/settings/delete/1');
        $response->assertSessionHas('danger', 'You can not delete this setting !');
        $response->assertStatus(302);
    }
}
