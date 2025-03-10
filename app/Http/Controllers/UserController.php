<?php

namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Xetaravel\Models\Badge;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\UserValidator;
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

        if (in_array($action, ['show'])) {
            $this->breadcrumbs->addCrumb('<i class="fa-regular fa-id-card mr-2"></i> Profile', route('page.index'));
        }
    }

    /**
     * Show the user profile page.
     *
     * @param string $slug The slug of the user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, string $slug)
    {
        $user = User::with('articles', 'comments')
            ->where('slug', Str::lower($slug))
            ->first();

        if (is_null($user)) {
            return redirect()
                ->route('page.index')
                ->with('danger', 'This user doesn\'t exist or has been deleted !');
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
            $user->profile_url
        );

        $badges = Badge::all();

        //dd($discussPosts);

        $articles = collect($articles);

        $activities = $articles->merge($comments)->merge($discussPosts)->sortBy('created_at', SORT_NATURAL, true);
        //dd($activities);

        //$level = UserUtility::getLevel($user->experiences_total);
        $level = UserUtility::getLevel($user->experiences_total);

        if ($level['maxLevel'] == true) {
            $level['currentProgression'] = 100;
        } elseif ($level['matchExactXPLevel'] == true) {
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
     * Show the settings form.
     *
     * @return \Illuminate\View\View
     */
    public function showSettingsForm(): View
    {
        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-user-gear mr-2"></i> Settings',
            route('users.user.settings')
        );

        return view('user.settings', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Handle an update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $type = $request->input('type');

        switch ($type) {
            case 'email':
                return $this->updateEmail($request);

            case 'password':
                return $this->updatePassword($request);

            case 'newpassword':
                return $this->createPassword($request);

            default:
                return back()
                    ->withInput()
                    ->with('danger', 'Invalid type.');
        }
    }

    /**
     * Handle the delete request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Your Password does not match !');
        }
        Auth::logout();

        if ($user->delete()) {
            return redirect()
                ->route('page.index')
                ->with('success', 'Your Account has been deleted successfully !');
        }

        return redirect()
            ->route('page.index')
            ->with('danger', 'An error occurred while deleting your account !');
    }

    /**
     * Handle a E-mail update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateEmail(Request $request): RedirectResponse
    {
        UserValidator::updateEmail($request->all())->validate();
        UserRepository::updateEmail($request->all(), Auth::user());

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Your E-mail has been updated successfully !');
    }

    /**
     * Handle a Password update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('oldpassword'), $user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Your current Password does not match !');
        }

        UserValidator::updatePassword($request->all())->validate();
        UserRepository::updatePassword($request->all(), $user);

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Your Password has been updated successfully !');
    }

    /**
     * Handle a Password create request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createPassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!is_null($user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'You have already set a password.');
        }

        UserValidator::createPassword($request->all())->validate();
        UserRepository::createPassword($request->all(), $user);

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Your password has been created successfully!');
    }
}
