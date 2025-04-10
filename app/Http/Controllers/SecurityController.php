<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Detection\Exception\MobileDetectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaravel\Models\Session;
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
            '<i class="fa-solid fa-user-shield mr-2"></i> Security',
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
        $records = Session::expires()->where('user_id', Auth::id())->get();

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
}
