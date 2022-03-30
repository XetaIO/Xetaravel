<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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

        $sessions = [];

        foreach ($records as $record) {
            $infos = get_browser($record->user_agent);

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
