<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Phattarachai\LaravelMobileDetect\Agent;
use Xetaravel\Models\Session;

class SecurityController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Security', route('users.security.index'));
    }

    /**
     * Show the security index page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $records = Session::expires()->where('user_id', Auth::id())->get();

        $agent = new Agent();

        $sessions = [];

        foreach ($records as $record) {
            $agent->setUserAgent($record->user_agent);

            $device_type = ($agent->isDesktop() ? 'desktop' :
                                            $agent->isPhone()) ? 'phone' :
                                            ($agent->isTablet() ? 'tablet' : 'unknown');

            $infos = [
                'platform' => $agent->platform(),
                'platform_version' => $agent->version((string) $agent->platform()),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version((string) $agent->browser()),
                'desktop' => $agent->isDesktop(),
                'phone' => $agent->isPhone(),
                'tablet' => $agent->isTablet(),
                'device_type' => $device_type
            ];

            $record->infos = $infos;

            array_push($sessions, $record);
        }

        $sessionId = $request->session()->getId();

        return view('security.index', [
            'sessions' => $sessions,
            'sessionId' => $sessionId,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}
