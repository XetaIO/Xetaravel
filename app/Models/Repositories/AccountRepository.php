<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Account;

class AccountRepository
{
    /**
     * Update the account if it exist or create and save it.
     *
     * @param array $data The data used to update/create the user.
     *
     * @return \Xetaravel\Models\Account
     */
    public static function update(array $data): Account
    {
        return Account::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'user_id' => Auth::user()->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'facebook' => $data['facebook'],
                'twitter' => $data['twitter'],
                'biography' => $data['biography'],
                'signature' => $data['signature']
            ]
        );
    }
}
