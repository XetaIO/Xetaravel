<?php
namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Repositories\ActivityLogRepository;

class ActivityLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }

        $data = [
            'url' => $request->path(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'last_activity' => time()
        ];

        $user = $request->user()->getKey();

        ActivityLogRepository::update($data, $user);

        return $next($request);
    }
}
