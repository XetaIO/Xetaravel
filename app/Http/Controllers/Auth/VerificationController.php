<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Auth;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected string $redirectTo = 'auth/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param Request $request
     * @param string $hash The email of the user encoded to base64.
     *
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function show(Request $request, string $hash)
    {
        return view('Auth.verify', compact('hash'));
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            throw new AuthorizationException();
        }

        if (!hash_equals((string) $request->route('hash'), base64_encode($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        Auth::login($user, true);

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect($this->redirectPath())
                        ->with('verified', true)
                        ->success("Your Email has been verified!");
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function resend(Request $request)
    {
        $email = base64_decode($request->input('hash'));
        $user = User::where('email', $email)->first();

        if (!$user || $user->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect($this->redirectPath());
        }

        $user->sendEmailVerificationNotification();

        return $request->wantsJson()
                    ? new JsonResponse([], 202)
                    : back()->with('resent', true);
    }
}
