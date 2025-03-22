<?php

declare(strict_types=1);

namespace Xetaravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Xetaravel\Events\Badges\LeaderboardEvent;
use Xetaravel\Models\User;

class Leaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Leaderboard and dispatch the rewards for the top 3 users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Fetch the first 3 users that have the most experience and NOT the role banished.
        $users = User::whereDoesntHave('roles', function (Builder $query) {
            $query->where('slug', 'banished');
        })
        ->orderBy('experiences_total', 'desc')
        ->limit(3)
        ->get();

        foreach ($users as $user) {
            //Dispatch the event.
            event(new LeaderboardEvent($user));
        }
    }
}
