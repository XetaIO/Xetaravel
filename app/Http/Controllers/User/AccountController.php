<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\AccountValidator;

class AccountController extends Controller
{
    /**
     * Show the account update form.
     *
     * @return View
     */
    public function index(): View
    {
        $user = User::with('account')->find(Auth::id());

        $this->breadcrumbs->addCrumb('
                <svg class="inline w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l293.1 0c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1l-91.4 0zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"></path></svg>
                Account', route('user.account.index'));

        return view('account.index', ['user' => $user, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Handle an account update request for the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        AccountValidator::update($request->all())->validate();
        $account = AccountRepository::update($request->all(), Auth::id());

        $parser = new MentionParser($account, [
            'regex' => config('mentions.regex'),
            'mention' => false
        ]);
        $signature = $parser->parse($account->signature);
        $biography = $parser->parse($account->biography);

        $account->signature = $signature;
        $account->biography = $biography;
        $account->save();

        $user = User::find(Auth::id());

        if (!is_null($request->file('avatar'))) {
            $user->clearMediaCollection('avatar');
            $user->addMedia($request->file('avatar'))
                ->preservingOriginal()
                ->setName(mb_substr(md5($user->username), 0, 10))
                ->setFileName(mb_substr(md5($user->username), 0, 10))
                ->toMediaCollection('avatar');
        }

        return redirect()
            ->route('user.account.index')
            ->success('Your account has been updated successfully !');
    }
}
