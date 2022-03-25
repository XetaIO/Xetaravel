<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class DiscussController extends Controller
{
    /**
     * Display all conversations.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $conversations = DiscussConversation::with('User', 'Category', 'FirstPost', 'LastPost')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('xetaravel.pagination.discuss.conversation_per_page'));

        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::index', compact('breadcrumbs', 'conversations'));
    }

    /**
     * Display the Leaderboard.
     *
     * @return \Illuminate\View\View
     */
    public function leaderboard(): View
    {

        $secondes = 1; //config('badges.users.pillarofcommunity.cache_lifetime_in_secondes'); // 86400 -> 24H

        $users = Cache::remember('Badges.users.pillarofcommunity', $secondes, function () {
            $users = User::whereDoesntHave('roles', function (Builder $query) {
                $query->where('slug', 'banished'); // Select all user that does not have the role "banished"
            })
            ->orderBy('experiences_total', 'desc')
            ->limit(15)
            ->get();

            return $users;
        });

        $breadcrumbs = $this->breadcrumbs->addCrumb('Leaderboard', route('discuss.leaderboard'));

        return view('Discuss::leaderboard', compact('breadcrumbs', 'users'));
    }
}
