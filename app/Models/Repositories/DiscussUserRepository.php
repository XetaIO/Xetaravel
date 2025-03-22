<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\DiscussUser;

class DiscussUserRepository
{
    /**
     * Create a new post instance after a valid validation.
     *
     * @param array $data The data used to create the user.
     *
     * @return DiscussUser
     */
    public static function create(array $data): DiscussUser
    {
        return DiscussUser::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'conversation_id' => $data['conversation_id']
            ],
            [
                'conversation_id' => $data['conversation_id']
            ]
        );
    }
}
