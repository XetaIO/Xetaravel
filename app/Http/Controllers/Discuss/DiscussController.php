<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;

class DiscussController extends Controller
{
    /**
     * Display all conversations.
     * Handled by Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::index', compact('breadcrumbs'));
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

        $badge = Badge::where('slug', 'topleaderboard')->first();

        return view('Discuss::leaderboard', compact('breadcrumbs', 'users', 'badge'));
    }
}
