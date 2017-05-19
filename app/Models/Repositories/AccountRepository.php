<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Account;

class AccountRepository
{
    /**
     * Update the account if it exist or create and save it.
     *
     * @param array $data The data used to update/create the user.
     * @param int $id The user id related to the account.
     *
     * @return \Xetaravel\Models\Account
     */
    public static function update(array $data, int $id): Account
    {
        return Account::updateOrCreate(
            [
                'user_id' => $id
            ],
            [
                'user_id' => $id,
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
