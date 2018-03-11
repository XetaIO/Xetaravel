<?php
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
     * @param \Xetaravel\Models\User $user
     * @param string $ability
     *
     * @return true|void
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasPermission('manage.discuss.conversations')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the discuss conversation.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussConversation $discussConversation
     *
     * @return bool
     */
    public function update(User $user, DiscussConversation $discussConversation)
    {
        return $user->id === $discussConversation->user_id;
    }

    /**
     * Determine whether the user can delete the discuss conversation.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussConversation $discussConversation
     *
     * @return bool
     */
    public function delete(User $user, DiscussConversation $discussConversation)
    {
        return $user->id === $discussConversation->user_id;
    }
}
