<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Policies\DiscussPostPolicy;
use Xetaravel\Policies\DiscussConversationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DiscussPost::class => DiscussPostPolicy::class,
        DiscussConversation::class => DiscussConversationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
