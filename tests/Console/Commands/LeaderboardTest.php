<?php
namespace Tests\Console\Commands;

use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    /**
     * Test a console command.
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $this->artisan('leaderboard:update')->assertSuccessful();
    }
}
