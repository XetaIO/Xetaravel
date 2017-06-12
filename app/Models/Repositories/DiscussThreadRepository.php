<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\DiscussThread;

class DiscussThreadRepository
{

    /**
     * Create the new thread and save it.
     *
     * @param array $data The data used to create the thread.
     *
     * @return \Xetaravel\Models\DiscussThread
     */
    public static function create(array $data): DiscussThread
    {
        $thread = [
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'content' => $data['content']
        ];

        $user = Auth::user();

        if ($user->hasPermission('manage.discuss.threads')) {
            $thread += [
                'is_locked' => isset($data['is_locked']) ? true : false,
                'is_pinned' => isset($data['is_pinned']) ? true : false,
            ];
        }

        return DiscussThread::create($thread);
    }

    /**
     * Update the article data and save it.
     *
     * @param array $data The data used to update the article.
     * @param \Xetaravel\Models\Article $article The article to update.
     *
     * @return \Xetaravel\Models\Article
     */
    public static function update(array $data, Article $article): Article
    {
        $article->title = $data['title'];
        $article->category_id = $data['category_id'];
        $article->is_display = isset($data['is_display']) ? true : false;
        $article->content = $data['content'];
        $article->save();

        return $article;
    }
}
