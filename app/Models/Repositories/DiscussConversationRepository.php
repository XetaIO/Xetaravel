<?php
namespace Xetaravel\Models\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussUser;

class DiscussConversationRepository
{

    /**
     * Create the new conversation and save it.
     *
     * @param array $data The data used to create the conversation.
     *
     * @return \Xetaravel\Models\DiscussConversation
     */
    public static function create(array $data): DiscussConversation
    {
        $conversation = [
            'title' => $data['title'],
            'category_id' => $data['category_id']
        ];

        $user = Auth::user();

        if ($user->hasPermission('manage.discuss.conversations')) {
            $conversation += [
                'is_locked' => isset($data['is_locked']) ? true : false,
                'is_pinned' => isset($data['is_pinned']) ? true : false,
            ];
        }

        $conversation = DiscussConversation::create($conversation);

        $comment = DiscussPost::create([
            'conversation_id' => $conversation->id,
            'content' => $data['content']
        ]);

        $participant = DiscussUser::create([
            'conversation_id' => $conversation->id,
            'is_read' => 1
        ]);

        $conversation->first_post_id = $comment->id;
        $conversation->last_post_id = $comment->id;
        $conversation->save();

        $conversation->category->last_conversation_id = $conversation->getKey();
        $conversation->category->save();

        return $conversation;
    }

    /**
     * Update the conversation data and save it.
     *
     * @param array $data The data used to update the conversation.
     * @param \Xetaravel\Models\DiscussConversation $conversation The conversation to update.
     *
     * @return \Xetaravel\Models\DiscussConversation
     */
    public static function update(array $data, DiscussConversation $conversation): DiscussConversation
    {
        if (Auth::user()->hasPermission('manage.discuss.conversations')) {
            $data['is_pinned'] = isset($data['is_pinned']) ? true : false;
            $data['is_locked'] = isset($data['is_locked']) ? true : false;

            if ($conversation->is_pinned != $data['is_pinned'] && $data['is_pinned'] == true) {
                event(new ConversationWasPinnedEvent($conversation, Auth::user()));
            }

            if ($conversation->is_locked != $data['is_locked'] && $data['is_locked'] == true) {
                event(new ConversationWasLockedEvent($conversation, Auth::user()));
            }

            $conversation->is_locked = $data['is_locked'];
            $conversation->is_pinned = $data['is_pinned'];
        }

        if ($conversation->title != $data['title']) {
            event(new TitleWasChangedEvent($conversation, $data['title'], $conversation->title));

            $conversation->title = $data['title'];
        }

        if ($conversation->category_id != $data['category_id']) {
            event(new CategoryWasChangedEvent($conversation, $data['category_id'], $conversation->category_id));

            $conversation->category_id = $data['category_id'];
        }

        $conversation->is_edited = true;
        $conversation->edit_count++;
        $conversation->edited_user_id = Auth::id();
        $conversation->edited_at = Carbon::now();

        $conversation->save();

        return $conversation;
    }

    /**
     * Find the previous conversation related to the given conversation.
     *
     * @param \Xetaravel\Models\DiscussConversation $conversation
     *
     * @return \Xetaravel\Models\DiscussConversation|null
     */
    public static function findPreviousConversation(DiscussConversation $conversation)
    {
        return DiscussConversation::where('category_id', $conversation->category->getKey())
            ->where('created_at', '<', $conversation->created_at)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
