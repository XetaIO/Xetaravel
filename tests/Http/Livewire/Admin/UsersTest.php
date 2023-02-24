<?php
namespace Tests\Http\Livewire\Admin;

use Tests\TestCase;
use Xetaravel\Http\Livewire\Admin\Users;
use Xetaravel\Models\User;

class UsersTest extends TestCase
{
    /**
     * testUsersPageContainsLivewireComponent method
     *
     * @return void
     */
    public function testUsersPageContainsLivewireComponent()
    {
        $this->actingAs(User::find(1));
        $this->get('/admin/user')->assertSeeLivewire(Users::class);
    }
}
