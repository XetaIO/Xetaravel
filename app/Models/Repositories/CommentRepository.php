<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\BlogComment;

class CommentRepository
{
    /**
     * Create a new comment instance after a valid validation.
     *
     * @param array $data The data used to create the comment.
     * @param \Xetaravel\Models\User $user The current user.
     *
     * @return BlogComment
     */
    public static function create(array $data): BlogComment
    {
        return BlogComment::create([
            'article_id' => $data['article_id'],
            'content' => $data['content']
        ]);
    }
}
