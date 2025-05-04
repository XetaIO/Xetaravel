<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;

class DiscussController extends Controller
{
    /**
     * Display all conversations.
     * Handled by Livewire.
     *
     * @return View
     */
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::index', compact('breadcrumbs'));
    }

    /**
     * Display the Leaderboard.
     *
     * @return View
     */
    public function leaderboard(): View
    {
        $secondes = 1; //config('badges.users.pillarofcommunity.cache_lifetime_in_secondes'); // 86400 -> 24H

        $users = Cache::remember('Badges.users.pillarofcommunity', $secondes, function () {
            return User::with('account')
                ->whereDoesntHave('roles', function (Builder $query) {
                    $query->where('name', 'Banished'); // Select all user that does not have the role "banished"
                })
                ->orderBy('experiences_total', 'desc')
                ->limit(15)
                ->get();
        });

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="inline w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528 160l0 256c0 8.8-7.2 16-16 16l-192 0c0-44.2-35.8-80-80-80l-64 0c-44.2 0-80 35.8-80 80l-32 0c-8.8 0-16-7.2-16-16l0-256 480 0zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zM272 256a64 64 0 1 0 -128 0 64 64 0 1 0 128 0zm104-48c-13.3 0-24 10.7-24 24s10.7 24 24 24l80 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-80 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l80 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-80 0z"></path></svg>
            Leaderboard',
            route('discuss.leaderboard')
        );

        $badge = Badge::where('type', 'topLeaderboard')->first();

        return view('Discuss::leaderboard', compact('breadcrumbs', 'users', 'badge'));
    }
}
