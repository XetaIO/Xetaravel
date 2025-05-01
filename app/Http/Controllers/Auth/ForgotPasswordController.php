<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Http\Requests\Password\ResetRequest;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @return RedirectResponse
     */
    protected function sendResetLinkResponse(): RedirectResponse
    {
        return redirect()
            ->route('auth.login')
            ->success('We have e-mailed your password reset link!');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return View
     */
    public function showLinkRequestForm(): View
    {
        return view('Auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param ResetRequest $request
     *
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(ResetRequest $request): RedirectResponse
    {
        $request->validated();

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response === Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse()
                    : $this->sendResetLinkFailedResponse($request, $response);
    }
}
