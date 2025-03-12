<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Auth;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Lang;
use Illuminate\View\View;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Http\Controllers\Controller;

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
    protected string $redirectTo = '/';

    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected int $maxAttempts = 5;

    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */
    protected int $decayMinutes = 10;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('Auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->user()->hasVerifiedEmail()) {
                return $this->sendLoginResponse($request);
            }

            $user = $request->user()->getKey();

            $this->logout($request);

            return redirect(route('users.auth.verification.notice', base64_encode($user)));

            //return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request The request object.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request): RedirectResponse
    {
        return redirect()
            ->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => trans('auth.failed'),
                'password' => trans('auth.failed')
            ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request The request object.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function logout(Request $request): RedirectResponse|JsonResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/')->success('Thanks for your visit. See you soon !');
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Xetaravel\Models\User $user The user that has been logged in.
     *
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        event(new RegisterEvent($user));

        $request->session()->flash(
            'success',
            'Welcome back <strong>' . e($user->username) . '</strong>! You\'re successfully connected !'
        );
    }
}
