<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Xetaravel\Models\DiscussComment;
use Xetaravel\Models\DiscussThread;
use Xetaravel\Policies\DiscussCommentPolicy;
use Xetaravel\Policies\DiscussThreadPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DiscussComment::class => DiscussCommentPolicy::class,
        DiscussThread::class => DiscussThreadPolicy::class,
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
