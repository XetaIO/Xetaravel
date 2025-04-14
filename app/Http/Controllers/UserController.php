<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;
use Xetaravel\Utility\UserUtility;

class UserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $action = Route::getFacadeRoot()->current()->getActionMethod();

        if ($action === 'show') {
            $this->breadcrumbs->addCrumb(
                '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Profile',
                route('page.index')
            );
        }
    }

    /**
     * Show the user profile page.
     *
     * @param string $slug The slug of the user.
     *
     * @return RedirectResponse|View
     */
    public function show(string $slug)
    {
        $user = User::with('articles', 'comments')
            ->where('slug', Str::lower($slug))
            ->first();

        if (is_null($user)) {
            return redirect()
                ->route('page.index')
                ->error('This user does not exist or has been deleted !');
        }
        $articles = $user->articles()
            ->latest()
            ->take(config('xetaravel.pagination.user.articles_profile_page'))
            ->get();

        $comments = $user->comments()
            ->with('article')
            ->latest()
            ->take(config('xetaravel.pagination.user.comments_profile_page'))
            ->get();

        $discussPosts = $user->discussPosts()
            ->join('discuss_conversations', 'discuss_posts.conversation_id', '=', 'discuss_conversations.id')
            ->where('discuss_conversations.first_post_id', '!=', 'discuss_posts.id')
            ->select(
                'discuss_posts.*',
                'discuss_conversations.first_post_id AS conversation_first_post_id',
                'discuss_conversations.title AS conversation_title',
                'discuss_conversations.slug AS conversation_slug',
                'discuss_conversations.id AS conversation_id'
            )
            ->orderBy('discuss_posts.created_at', 'DESC')
            ->take(config('xetaravel.pagination.user.posts_profile_page'))
            ->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            e($user->username),
            $user->show_url
        );

        $badges = Badge::all();

        $articles = collect($articles);

        $activities = $articles->merge($comments)->merge($discussPosts)->sortBy('created_at', SORT_NATURAL, true);

        $level = UserUtility::getLevel($user->experiences_total);

        if ($level['maxLevel'] === true) {
            $level['currentProgression'] = 100;
        } elseif ($level['matchExactXPLevel'] === true) {
            $level['currentProgression'] = 0;
        } else {
            $level['currentProgression'] = ($level['currentUserExperience'] / $level['nextLevelExperience']) * 100;
        }

        return view(
            'user.show',
            compact('user', 'activities', 'articles', 'comments', 'breadcrumbs', 'level', 'badges')
        );
    }

    /**
     * Handle the delete request for the user.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()
                ->route('user.setting.index')
                ->error('Your Password does not match !');
        }
        Auth::logout();

        if ($user->delete()) {
            return redirect()
                ->route('page.index')
                ->success('Your account has been deleted successfully !');
        }

        return redirect()
            ->route('page.index')
            ->error('An error occurred while deleting your account !');
    }
}
