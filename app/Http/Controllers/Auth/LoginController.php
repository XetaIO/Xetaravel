<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Masmerise\Toaster\Toaster;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\User;

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
        parent::__construct();

        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
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
     * @param Request $request
     * @return RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if the login is not disabled, if yes check if the user is allowed to bypass it.
        $user = User::where($this->username(), $request->{$this->username()})->first();

        if (!settings('app_login_enabled') && !$user->hasPermissionTo('bypass login')) {
            return redirect()
                ->route('/')
                ->error('The login system is currently disabled, please try again later.');
        }

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
     * @param Request $request The request object.
     *
     * @return RedirectResponse
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
     * The user has been authenticated.
     *
     * @param Request $request The request object.
     * @param User $user The user that has been logged in.
     *
     * @return void
     */
    protected function authenticated(Request $request, User $user)
    {
        event(new RegisterEvent($user));

        Toaster::success("Welcome back <b>{$user->username}</b> !  You're successfully connected !");
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect('/')
            ->success('Thanks for your visit. See you soon !');
    }
}
