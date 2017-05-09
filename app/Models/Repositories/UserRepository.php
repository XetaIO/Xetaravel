<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\User;

class UserRepository
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     *
     * @return \Xetaravel\Models\User
     */
    public static function create(array $data): User
    {
        $ip = FacadeRequest::ip();

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'register_ip' => $ip,
            'last_login_ip' => $ip,
            'last_login' => new \DateTime()
        ]);
    }

    /**
     * Update the user's email after a valid email update.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updateEmail(array $data, User $user): bool
    {
        $user->email = $data['email'];

        return $user->save();
    }

    /**
     * Update the user's password after a valid password update.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updatePassword(array $data, User $user): bool
    {
        $user->password = Hash::make($data['password']);

        return $user->save();
    }

    /**
     * Find the notifications data for the notification sidebar.
     *
     * @param int $userId The id of the user.
     *
     * @return array
     */
    public static function notificationsData($userId): array
    {
        $user = User::find($userId);

        return [
            'notifications' => $user->notifications->take(8),
            'hasUnreadNotifications' => $user->unreadNotifications->isNotEmpty(),
            'unredNotificationsCount' => $user->unreadNotifications->count()
        ];
    }
}
