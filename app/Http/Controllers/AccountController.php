<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\AccountValidator;

class AccountController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('<i class="fa-solid fa-user-pen mr-2"></i> Account', route('users.account.index'));
    }

    /**
     * Show the account update form.
     *
     * @return View
     */
    public function index(): View
    {
        $user = User::find(Auth::id());

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
            ->route('users.account.index')
            ->with('success', 'Your account has been updated successfully !');
    }
}
