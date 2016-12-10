<?php
namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Create a comment for an article.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(404);
        }

        // Check if the article exist and if its display.
        $article = Article::find($request->article_id);

        if (is_null($article) || $article->is_display == false) {
            return back()
                ->withInput()
                ->with('danger', 'This article doesn\'t exist or you cant not reply to it !');
        }

        Comment::validator($request->all())->validate();
        Comment::createComment($request->all(), auth()->user());

        return back()
            ->with('success', 'Your comment has been posted successfully !');
    }
}
