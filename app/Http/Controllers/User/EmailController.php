<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Http\Requests\User\UpdateEmailRequest;

class EmailController extends Controller
{
    /**
     * Updates the authenticated user's email.
     *
     * @param UpdateEmailRequest $request
     *
     * @return RedirectResponse
     */
    public function update(UpdateEmailRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->email = $request->input('email');

        if ($user->save()) {
            return redirect()
                ->route('user.setting.index')
                ->success('Your E-mail has been updated successfully !');
        }

        return redirect()
            ->route('user.setting.index')
            ->error('An error occurred while saving your E-mail!');
    }
}
