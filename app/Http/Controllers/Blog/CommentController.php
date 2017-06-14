<?php
namespace Xetaravel\Http\Controllers\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\CommentEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;
use Xetaravel\Models\Repositories\CommentRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\CommentValidator;

class CommentController extends Controller
{
    /**
     * Create a comment for an article.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $article = Article::findOrFail($request->article_id);

        if ($article->is_display == false) {
            return back()
                ->withInput()
                ->with('danger', 'This article doesn\'t exist or you can not reply to it !');
        }

        if (Comment::isFlooding('xetaravel.flood.blog.comment')) {
            return back()
                ->withInput()
                ->with('danger', 'Wow, keep calm bro, and try to not flood !');
        }

        CommentValidator::create($request->all())->validate();
        $comment = CommentRepository::create($request->all());

        $parser = new MentionParser($comment);
        $content = $parser->parse($comment->content);

        $comment->content = $content;
        $comment->save();

        // We must find the user else we won't see the updated comment_count.
        event(new CommentEvent(User::find(Auth::id())));

        return redirect()
            ->route('blog.comment.show', ['id' => $comment->getKey()])
            ->with('success', 'Your comment has been posted successfully !');
    }

    /**
     * Redirect an user to an article, page and comment.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The ID of the comment.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, int $id): RedirectResponse
    {
        $comment = Comment::findOrFail($id);

        $commentsBefore = Comment::where([
            ['article_id', $comment->article_id],
            ['created_at', '<', $comment->created_at]
        ])->count();

        $commentsPerPage = config('xetaravel.pagination.blog.comment_per_page');

        $page = floor($commentsBefore / $commentsPerPage) + 1;
        $page = ($page > 1) ? $page : 1;

        $request->session()->keep(['primary', 'danger', 'warning', 'success', 'info']);

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
