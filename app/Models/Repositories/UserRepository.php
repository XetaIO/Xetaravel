<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\User;

class UserRepository
{
    /**
     * Find the authors of articles with most articles for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sidebar(): Collection
    {
        return User::where('blog_article_count', '>=', 1)
            ->take(config('xetaravel.blog.users_sidebar'))
            ->orderBy('blog_article_count', 'desc')
            ->get();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     * @param array $providerData The additional data provided by the provider.
     * @param bool $provider Whether the user is registered with a Social Provider.
     *
     * @return User
     */
    public static function create(array $data, array $providerData = [], bool $provider = false): User
    {
        $ip = FacadeRequest::ip();

        $user = [
            'username' => $data['username'],
            'email' => $data['email'],
            'register_ip' => $ip,
            'last_login_ip' => $ip,
            'last_login_date' => new \DateTime()
        ];

        if ($provider === false) {
            $user += [
                'password' => bcrypt($data['password'])
            ];
        } else {
            $user += $providerData;
        }

        return User::create($user);
    }

    /**
     * Update the user informations after a valid update request.
     *
     * @param array $data The data used to update the user.
     * @param User $user The user to update.
     *
     * @return bool
     */
    public static function update(array $data, User $user): bool
    {
        $user->username = $data['username'];
        $user->email = $data['email'];

        return $user->save();
    }

    /**
     * Update the user's email after a valid email update.
     *
     * @param array $data The data used to update the user.
     * @param User $user The user to update.
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
     * @param User $user The user to update.
     *
     * @return bool
     */
    public static function updatePassword(array $data, User $user): bool
    {
        $user->password = Hash::make($data['password']);

        return $user->save();
    }

    /**
     * Create the user's password after a valid password create. (For Discord Users)
     *
     * @param array $data The data used to update the user.
     * @param User $user The user to update.
     *
     * @return bool
     */
    public static function createPassword(array $data, User $user): bool
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
            'notifications' => $user->notifications()->take(6)->get(),
            'hasUnreadNotifications' => $user->unreadNotifications->isNotEmpty(),
            'unreadNotificationsCount' => $user->unreadNotifications->count()
        ];
    }
}
