<?php
namespace Xetaravel\Http\Controllers\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\CommentEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Article;
use Xetaravel\Models\Repositories\CommentRepository;
use Xetaravel\Models\Validators\CommentValidator;

class CommentController extends Controller
{
    /**
     * Create a comment for an article.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        // Check if the article exist and if its display.
        $article = Article::find($request->article_id);

        if (is_null($article) || $article->is_display == false) {
            return back()
                ->withInput()
                ->with('danger', 'This article doesn\'t exist or you can not reply to it !');
        }

        CommentValidator::create($request->all())->validate();
        CommentRepository::create($request->all(), auth()->user());

        event(new CommentEvent(Auth::user()));

        return back()
            ->with('success', 'Your comment has been posted successfully !');
    }
}
