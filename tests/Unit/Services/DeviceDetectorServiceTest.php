<?php

namespace Tests\Unit\Services;

use Xetaravel\Services\DeviceDetectorService;
use PHPUnit\Framework\TestCase;

class DeviceDetectorServiceTest extends TestCase
{
    protected DeviceDetectorService $deviceDetector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deviceDetector = new DeviceDetectorService();
    }

    public function testGetPlatform()
    {
        $userAgents = $this->userAgentProvider();

        foreach ($userAgents as $userAgent) {
            $_SERVER['HTTP_USER_AGENT'] = $userAgent[0];
            $this->assertEquals($userAgent[1], $this->deviceDetector->getPlatform($userAgent[0]));
        }
    }

    public function testGetPlatformVersion()
    {
        $userAgents = $this->userAgentProvider();

        foreach ($userAgents as $userAgent) {
            $_SERVER['HTTP_USER_AGENT'] = $userAgent[0];
            $this->assertEquals($userAgent[2], $this->deviceDetector->getPlatformVersion($userAgent[0]));
        }
    }

    public function testGetBrowser()
    {
        $userAgents = $this->userAgentProvider();

        foreach ($userAgents as $userAgent) {
            $_SERVER['HTTP_USER_AGENT'] = $userAgent[0];
            $this->assertEquals($userAgent[3], $this->deviceDetector->getBrowser($userAgent[0]));
        }
    }

    public function testGetBrowserVersion()
    {
        $userAgents = $this->userAgentProvider();

        foreach ($userAgents as $userAgent) {
            $_SERVER['HTTP_USER_AGENT'] = $userAgent[0];
            $this->assertEquals($userAgent[4], $this->deviceDetector->getBrowserVersion($userAgent[0]));
        }
    }

    public function testGetDeviceType()
    {
        $userAgents = $this->deviceTypeProvider();

        foreach ($userAgents as $userAgent) {
            $_SERVER['HTTP_USER_AGENT'] = $userAgent[0];
            $this->assertEquals($userAgent[1], $this->deviceDetector->getDeviceType($userAgent[0]));
        }
    }

    public function userAgentProvider(): array
    {
        return [
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'Windows', '10.0', 'Chrome', '91.0.4472.124', 'desktop'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 14_4 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/537.36', 'iOS', '14.4', 'Safari', '14.0', 'phone'],
            ['Mozilla/5.0 (iPad; CPU OS 14_4 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/537.36', 'iOS', '14.4', 'Safari', '14.0', 'tablet'],
        ];
    }

    public function deviceTypeProvider(): array
    {
        return [
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'desktop'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 14_4 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/537.36', 'phone'],
            ['Mozilla/5.0 (iPad; CPU OS 14_4 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/537.36', 'tablet'],
            ['Mozilla/5.0 (Linux; Android 9; SM-G960F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36', 'phone'],
            ['Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0', 'desktop'],
        ];
    }
}
