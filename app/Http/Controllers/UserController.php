<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug, $id)
    {
        
        // Check if the article exist and if its display.
        $user = User::with('articles', 'comments')
            ->where('id', $id)
            ->first();

        if (is_null($user)) {
            return redirect()
                ->route('page_index')
                ->with('danger', 'This user doesn\'t exist or has been deleted !');
        }

        return view('user.show', ['user' => $user]);
    }
}
