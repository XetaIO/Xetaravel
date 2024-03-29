<?php
namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Ultraware\Roles\Exceptions\PermissionDeniedException;

class VerifyPermission
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param int|string $permission
     * @return mixed
     * @throws \Ultraware\Roles\Exceptions\PermissionDeniedException
     */
    public function handle($request, Closure $next, ...$permission)
    {
        if (!$this->auth->check() && in_array('allowGuest', $permission)) {
            return $next($request);
        }

        if ($this->auth->check() && $this->auth->user()->hasPermission($permission[0])) {
            return $next($request);
        }

        throw new PermissionDeniedException($permission[0]);
    }
}
