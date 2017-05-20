<?php
namespace Xetaravel\Http\Controllers\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\CommentEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Article;
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

        CommentValidator::create($request->all())->validate();
        CommentRepository::create($request->all(), auth()->user());

        // We must find the user else we won't see the updated comment_count.
        event(new CommentEvent(User::find(Auth::user()->id)));

        return back()
            ->with('success', 'Your comment has been posted successfully !');
    }
}
