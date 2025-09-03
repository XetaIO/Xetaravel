<?php

declare(strict_types=1);

namespace Xetaravel\Services;

use Detection\Exception\MobileDetectException;
use Detection\MobileDetect;

class DeviceDetectorService
{
    protected MobileDetect $detect;

    public function __construct()
    {
        $this->detect = new MobileDetect();
    }

    /**
     * Get the platform.
     *
     * @param string|null $userAgent
     *
     * @return string
     */
    public function getPlatform(?string $userAgent = null): string
    {
        if ($userAgent) {
            $this->detect->setUserAgent($userAgent);
        }

        if ($this->detect->isiOS()) {
            return 'iOS';
        }
        if ($this->detect->isAndroidOS()) {
            return 'Android';
        }
        if ($this->detect->isWindowsMobileOS()) {
            return 'Windows Phone';
        }
        if ($userAgent && mb_stripos($userAgent, 'Windows NT') !== false) {
            return 'Windows';
        }
        if ($userAgent && mb_stripos($userAgent, 'Macintosh') !== false) {
            return 'macOS';
        }
        if ($userAgent && mb_stripos($userAgent, 'Linux') !== false) {
            return 'Linux';
        }
        return 'Unknown OS';
    }

    /**
     * Get the platform version.
     *
     * @param string $userAgent
     *
     * @return string
     */
    public function getPlatformVersion(string $userAgent): string
    {
        preg_match('/(Windows NT|Android|CPU (iPhone )?OS|Mac OS X|Linux) ([0-9_\.]+)/i', $userAgent, $matches);

        return isset($matches[3]) ? str_replace('_', '.', $matches[3]) : 'Unknown Version';
    }

    /**
     * Get the browser.
     *
     * @param string $userAgent
     *
     * @return string
     */
    public function getBrowser(string $userAgent): string
    {
        if (mb_stripos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        }
        if (mb_stripos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        }
        if (mb_stripos($userAgent, 'Safari') !== false && mb_stripos($userAgent, 'Chrome') === false) {
            return 'Safari';
        }
        if (mb_stripos($userAgent, 'Edge') !== false) {
            return 'Edge';
        }
        if (mb_stripos($userAgent, 'OPR') !== false || mb_stripos($userAgent, 'Opera') !== false) {
            return 'Opera';
        }
        if (mb_stripos($userAgent, 'MSIE') !== false || mb_stripos($userAgent, 'Trident') !== false) {
            return 'Internet Explorer';
        }
        return 'Unknown Browser';
    }

    /**
     * Get the version of the browser.
     *
     * @param string $userAgent
     *
     * @return string
     */
    public function getBrowserVersion(string $userAgent): string
    {
        $browser = $this->getBrowser($userAgent);
        $version = 'Unknown Version';

        $patterns = [
            'Chrome' => '/Chrome\/([0-9\.]+)/',
            'Firefox' => '/Firefox\/([0-9\.]+)/',
            'Safari' => '/Version\/([0-9\.]+)/',
            'Edge' => '/Edg\/([0-9\.]+)/',
            'Opera' => '/(Opera|OPR)\/([0-9\.]+)/',
            'Internet Explorer' => '/(MSIE |rv:)([0-9\.]+)/',
        ];

        if (isset($patterns[$browser])) {
            preg_match($patterns[$browser], $userAgent, $matches);
            $version = $matches[1] ?? $matches[2] ?? 'Unknown Version';
        }

        return $version;
    }

    /**
     * Return the type of device (desktop, phone, tablet)
     *
     * @param string|null $userAgent
     *
     * @return string
     *
     * @throws MobileDetectException
     */
    public function getDeviceType(?string $userAgent = null): string
    {
        if ($userAgent) {
            $this->detect->setUserAgent($userAgent);
        }

        if ($this->detect->isTablet()) {
            return 'tablet';
        }

        if ($this->detect->isMobile()) {
            return 'phone';
        }

        return 'desktop';
    }
}
