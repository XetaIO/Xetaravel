<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()
            ->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
                'password' => Lang::get('auth.failed')
            ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request The request object.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Thanks for your visit. See you soon !');
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param mixed $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $request->session()->flash('success', 'You\'re successfully connected !');
    }
}
