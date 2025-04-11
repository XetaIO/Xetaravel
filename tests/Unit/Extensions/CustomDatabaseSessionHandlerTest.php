<?php

declare(strict_types=1);

namespace Tests\Unit\Extensions;

use Illuminate\Database\ConnectionInterface;
use Xetaravel\Extensions\CustomDatabaseSessionHandler;
use Mockery;
use Tests\TestCase;
use Xetaravel\Services\DeviceDetectorService;

class CustomDatabaseSessionHandlerTest extends TestCase
{
    protected $connection;
    protected $deviceDetectorService;
    protected $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = Mockery::mock(ConnectionInterface::class)->shouldIgnoreMissing();

        $this->deviceDetectorService = Mockery::mock(DeviceDetectorService::class);
        $this->deviceDetectorService->shouldReceive('getDeviceType')->andReturn('desktop');
        $this->deviceDetectorService->shouldReceive('getBrowser')->andReturn('Chrome');
        $this->deviceDetectorService->shouldReceive('getBrowserVersion')->andReturn('90');
        $this->deviceDetectorService->shouldReceive('getPlatform')->andReturn('Windows');
        $this->deviceDetectorService->shouldReceive('getPlatformVersion')->andReturn('10');

        $this->sessionHandler = new CustomDatabaseSessionHandler(
            $this->connection,
            'sessions',
            120,
            app(),
            $this->deviceDetectorService
        );
    }

    public function test_write_session()
    {
        $sessionId = 'dummy_session_id';
        $sessionData = 'test_data';

        $this->connection->shouldReceive('table')
            ->with('sessions')
            ->andReturnSelf();

        $this->connection->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(function ($arg) use ($sessionId) {
                return $arg['id'] === $sessionId &&
                    $arg['device_type'] === 'desktop' &&
                    $arg['browser'] === 'Chrome' &&
                    $arg['platform'] === 'Windows' &&
                    $arg['platform_version'] === '10' &&
                    $arg['browser_version'] === '90';
            }))
            ->andReturn(true);

        $this->assertTrue($this->sessionHandler->write($sessionId, $sessionData));
    }
}
