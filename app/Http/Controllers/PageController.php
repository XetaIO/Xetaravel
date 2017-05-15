<?php
namespace Xetaravel\Http\Controllers;

use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('category', 'user')
            ->latest()
            ->limit(6)
            ->get();

        $comments = Comment::with('user')
            ->whereHas('article', function ($query) {
                $query->where('is_display', true);
            })
            ->latest()
            ->limit(4)
            ->get();

        return view('page.index', ['articles' => $articles, 'comments' => $comments]);
    }

    /**
     * Display the banished page.
     *
     * @return \Illuminate\Http\Response
     */
    public function banished()
    {
        if (!Auth::user()->hasRole('banished')) {
            return redirect()
                ->route('page.index');
        }

        return view('page.banished');
    }
}
