<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;
use Xetaravel\Http\Controllers\User\SecurityController;
use Xetaravel\Models\User;
use Xetaravel\Services\DeviceDetectorService;

class SecurityControllerTest extends TestCase
{
    public function test_index_view_is_returned_with_session_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        // Insert a fake session in the database
        DB::table(config('session.table'))->insert([
            'id' => 'fake-session-id',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'payload' => 'fake-payload',
            'last_activity' => time(),
        ]);

        // Mock the DeviceDetectorService
        $mockDetector = Mockery::mock(DeviceDetectorService::class);
        $mockDetector->shouldReceive('getPlatform')->andReturn('Windows');
        $mockDetector->shouldReceive('getPlatformVersion')->andReturn('10');
        $mockDetector->shouldReceive('getBrowser')->andReturn('Chrome');
        $mockDetector->shouldReceive('getBrowserVersion')->andReturn('105.0');
        $mockDetector->shouldReceive('getDeviceType')->andReturn('desktop');

        $this->app->instance(DeviceDetectorService::class, $mockDetector);

        // Make GET request to the route
        $response = $this->get(route('user.security.index'));

        // Assert the view and data
        $response->assertOk();
        $response->assertViewIs('security.index');
        $response->assertViewHas('sessions');
        $response->assertViewHas('sessionId');

        $sessions = $response->viewData('sessions');
        $this->assertNotEmpty($sessions);
        $this->assertEquals('Windows', $sessions[0]->infos['platform']);
        $this->assertEquals('Chrome', $sessions[0]->infos['browser']);
    }

    public function test_get_active_sessions_returns_expected_results()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $controller = new SecurityController(Mockery::mock(DeviceDetectorService::class));

        $fakeSessions = collect([
            (object)[
                'id' => 1,
                'user_id' => $user->id,
                'user_agent' => 'agent',
                'last_activity' => time()
            ]
        ]);

        DB::shouldReceive('table')
            ->once()
            ->with(config('session.table'))
            ->andReturnSelf();
        DB::shouldReceive('where')->twice()->andReturnSelf();
        DB::shouldReceive('get')->andReturn($fakeSessions);

        Auth::shouldReceive('id')->andReturn($user->id);

        $sessions = $controller->getActiveSessions();
        $this->assertCount(1, $sessions);
        $this->assertEquals($user->id, $sessions[0]->user_id);
    }
}
