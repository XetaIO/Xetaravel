<?php
namespace Xetaravel\Http\Controllers;

use Xetaravel\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Account', route('users_account_index'));
    }

    /**
     * Show the account update form.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = User::find(Auth::user()->id);

        $this->breadcrumbs->setCssClasses('breadcrumb');

        return view('account.index', ['user' => $user, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        if ($this->updateUser($request->all())) {
            $user = User::find(Auth::user()->id);

            // Handle the avatar upload.
            if (!is_null($request->file('avatar'))) {
                $user->clearMediaCollection('avatar');
                $user->addMedia($request->file('avatar'))
                    ->preservingOriginal()
                    ->setName(substr(md5($user->username), 0, 10))
                    ->setFileName(substr(md5($user->username), 0, 10) . '.' . $request->file('avatar')->extension())
                    ->toMediaCollection('avatar');
            }

            return redirect()
                ->route('users_account_index')
                ->with('success', 'Your account has been updated successfully !');
        } else {
            return redirect()
                ->route('users_account_index')
                ->with('danger', 'An error occurred while saving your informations !');
        }
    }

    /**
     * Update the user instance after a valid account update.
     *
     * @param array $data The data used to update the user.
     *
     * @return int
     */
    protected function updateUser(array $data): int
    {
        return User::where('id', Auth::user()->id)
            ->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'facebook' => $data['facebook'],
                'twitter' => $data['twitter'],
                'biography' => $data['biography'],
                'signature' => $data['signature']
            ]);
    }

    /**
     * Get a validator for an incoming account request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data): Validator
    {
        $rules = [
            'first_name' => 'max:100',
            'last_name' => 'max:100',
            'avatar' => 'image',
            'facebook' => 'max:50',
            'twitter' => 'max:50'
        ];

        return FacadeValidator::make($data, $rules);
    }
}
