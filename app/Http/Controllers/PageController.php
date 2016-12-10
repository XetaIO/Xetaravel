<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

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
            ->limit(4)
            ->get();

        $comments = Comment::with('article', 'user')
            ->latest()
            ->limit(4)
            ->get();

        return view('page.index', ['articles' => $articles, 'comments' => $comments]);
    }
}
