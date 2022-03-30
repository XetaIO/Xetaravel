<?php
namespace Xetaravel\Http\Middleware;

use Closure;
use Xetaravel\Models\Session;
use Xetaravel\Models\Repositories\SessionRepository;

class SessionLogs
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

        $session = Session::where('id', $request->session()->getId())->first();

        $data = [
            'url' => $request->path(),
            'method' => $request->method()
        ];

        SessionRepository::update($data, $session);

        return $next($request);
    }
}
