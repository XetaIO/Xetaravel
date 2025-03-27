<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\DiscussConversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize all actions if the user has the given permission.
     *
     * @param User $user
     * @param string $ability
     *
     * @return true|void
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasPermissionTo('manage discuss conversation')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create a discuss conversation.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create discuss conversation');
    }

    /**
     * Determine whether the user can update the discuss conversation.
     *
     * @param User $user
     * @param DiscussConversation $discussConversation
     *
     * @return bool
     */
    public function update(User $user, DiscussConversation $discussConversation): bool
    {
        return $user->id === $discussConversation->user_id;
    }

    /**
     * Determine whether the user can delete the discuss conversation.
     *
     * @param User $user
     * @param DiscussConversation $discussConversation
     *
     * @return bool
     */
    public function delete(User $user, DiscussConversation $discussConversation): bool
    {
        return $user->id === $discussConversation->user_id;
    }

    /**
     * Determine whether the user can make a discuss post as solved.
     * User must be the creator of the conversation to be able to make a
     * post as solved.
     *
     * @param User $user
     * @param DiscussConversation $discussConversation
     *
     * @return bool
     */
    public function solved(User $user, DiscussConversation $discussConversation): bool
    {
        return $user->id === $discussConversation->user_id;
    }

    /**
     * Determine whether the user can pin a conversation.
     *
     * @param User $user
     *
     * @return bool
     */
    public function pin(User $user): bool
    {
        return $user->hasPermissionTo('pin discuss conversation');
    }

    /**
     * Determine whether the user can lock a conversation.
     *
     * @param User $user
     *
     * @return bool
     */
    public function lock(User $user): bool
    {
        return $user->hasPermissionTo('lock discuss conversation');
    }
}
