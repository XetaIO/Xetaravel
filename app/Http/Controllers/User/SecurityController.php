<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\User;

use Detection\Exception\MobileDetectException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Services\DeviceDetectorService;

class SecurityController extends Controller
{
    protected DeviceDetectorService $detector;

    /**
     * Constructor
     */
    public function __construct(DeviceDetectorService $detector)
    {
        parent::__construct();
        $this->detector = $detector;

        $this->breadcrumbs->addCrumb(
            '<svg class="inline w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c1.8 0 3.5-.2 5.3-.5c-76.3-55.1-99.8-141-103.1-200.2c-16.1-4.8-33.1-7.3-50.7-7.3l-91.4 0zm308.8-78.3l-120 48C358 277.4 352 286.2 352 296c0 63.3 25.9 168.8 134.8 214.2c5.9 2.5 12.6 2.5 18.5 0C614.1 464.8 640 359.3 640 296c0-9.8-6-18.6-15.1-22.3l-120-48c-5.7-2.3-12.1-2.3-17.8 0zM591.4 312c-3.9 50.7-27.2 116.7-95.4 149.7l0-187.8L591.4 312z"></path></svg>
                          Security',
            route('user.security.index')
        );
    }

    /**
     * Show the security index page.
     *
     * @param Request $request
     *
     * @return View
     *
     * @throws MobileDetectException
     */
    public function index(Request $request): View
    {
        $records = $this->getActiveSessions();

        $sessions = [];

        foreach ($records as $record) {
            $infos = [
                'platform' => $this->detector->getPlatform($record->user_agent),
                'platform_version' => $this->detector->getPlatformVersion($record->user_agent),
                'browser' => $this->detector->getBrowser($record->user_agent),
                'browser_version' => $this->detector->getBrowserVersion($record->user_agent),
                'device_type' => $this->detector->getDeviceType($record->user_agent)
            ];
            $record->infos = $infos;

            $sessions[] = $record;
        }

        $sessionId = $request->session()->getId();

        return view('security.index', [
            'sessions' => $sessions,
            'sessionId' => $sessionId,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Récupère toutes les sessions non expirées de l'utilisateur connecté.
     *
     * @return Collection
     */
    public function getActiveSessions()
    {
        $sessionLifetime = config('session.lifetime') * 60;

        $expirationTime = time() - $sessionLifetime;

        return DB::table(config('session.table'))
            ->where('user_id', Auth::id())
            ->where('last_activity', '>', $expirationTime)
            ->get();
    }
}
