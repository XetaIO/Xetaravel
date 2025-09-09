<?php

declare(strict_types=1);

namespace Xetaravel\Extensions;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Session\DatabaseSessionHandler;
use Illuminate\Support\Arr;
use Xetaravel\Services\DeviceDetectorService;

class CustomDatabaseSessionHandler extends DatabaseSessionHandler
{
    protected DeviceDetectorService $device;

    public function __construct(ConnectionInterface $connection, $table, $minutes, $app, DeviceDetectorService $device)
    {
        parent::__construct($connection, $table, $minutes, $app);
        $this->device = $device;
    }

    protected function userId()
    {
        return auth()->check() ? auth()->id() : null;
    }

    public function write($sessionId, $data): bool
    {
        $currentTime = now();

        $userAgent = request()->userAgent();

        if (is_null($userAgent)) {
            $userAgent = '';
        }

        $payload = [
            'payload' => base64_encode($data),
            'last_activity' => time(),
            'url' => request()->path(),
            'method' => request()->method(),
            'platform' => $this->device->getPlatform($userAgent),
            'platform_version' => $this->device->getPlatformVersion($userAgent),
            'browser' => $this->device->getBrowser($userAgent),
            'browser_version' => $this->device->getBrowserVersion($userAgent),
            'device_type' => $this->device->getDeviceType($userAgent),
            'updated_at' => $currentTime
        ];

        if ($this->exists) {
            $this->connection->table($this->table)->where('id', $sessionId)->update($payload);
        } else {
            $payload += [
                'id' => $sessionId,
                'user_id' => $this->userId(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => $currentTime
            ];
            $this->connection->table($this->table)->insert(Arr::set($payload, 'id', $sessionId));
        }

        return $this->exists = true;
    }
}
