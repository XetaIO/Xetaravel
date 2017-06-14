<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\Comment;

class CommentRepository
{
    /**
     * Create a new comment instance after a valid validation.
     *
     * @param array $data The data used to create the comment.
     * @param \Xetaravel\Models\User $user The current user.
     *
     * @return \Xetaravel\Models\Comment
     */
    public static function create(array $data): Comment
    {
        return Comment::create([
            'article_id' => $data['article_id'],
            'content' => $data['content']
        ]);
    }
}
