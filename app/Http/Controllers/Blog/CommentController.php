<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Blog;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\BlogComment;

class CommentController extends Controller
{
    /**
     * Redirect a user to an article, page and comment.
     *
     * @param Request $request
     * @param int $id The ID of the comment.
     *
     * @return RedirectResponse
     *
     * @throws ModelNotFoundException
     */
    public function show(Request $request, int $id): RedirectResponse
    {
        $comment = BlogComment::findOrFail($id);

        $commentsBefore = BlogComment::where([
            ['blog_article_id', $comment->blog_article_id],
            ['created_at', '>', $comment->created_at]
        ])->count();

        $commentsPerPage = config('xetaravel.pagination.blog.comment_per_page');

        $page = floor($commentsBefore / $commentsPerPage) + 1;
        $page = ($page > 1) ? $page : 1;

        $request->session()->keep(['primary', 'error', 'warning', 'success', 'info']);

        return redirect()
            ->route(
                'blog.article.show',
                [
                    'slug' => $comment->article->slug,
                    'id' => $comment->article->id,
                    'page' => $page,
                    '#comment-' . $comment->getKey()
                ]
            );
    }
}
