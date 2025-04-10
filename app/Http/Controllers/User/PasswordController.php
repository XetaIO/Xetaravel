<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Http\Requests\CreatePasswordRequest;
use Xetaravel\Http\Requests\User\UpdatePasswordRequest;

class PasswordController extends Controller
{
    /**
     * Create the user's password for users registered with Socialite.
     *
     * @param CreatePasswordRequest $request
     *
     * @return RedirectResponse
     */
    public static function create(CreatePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if (!is_null($user->password)) {
            return redirect()
                ->route('user.setting.index')
                ->error('You have already set a password.');
        }

        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect()
                ->route('user.setting.index')
                ->success('Your Password has been created successfully !');
        }

        return redirect()
            ->route('user.setting.index')
            ->error('An error occurred while creating your Password !');
    }

    /**
     * Updates the authenticated user's password.
     *
     * @param UpdatePasswordRequest $request
     *
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()
                ->route('user.setting.index')
                ->error('Your current Password does not match !');
        }

        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect()
                ->route('user.setting.index')
                ->success('Your Password has been updated successfully !');
        }

        return redirect()
            ->route('user.setting.index')
            ->error('An error occurred while saving your Password !');
    }
}
