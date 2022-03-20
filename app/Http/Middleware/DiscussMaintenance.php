<?php
namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DiscussMaintenance
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
        // If the discuss is disabled and the user is not admin.
        if ((!Auth::user() && config('settings.discuss.enabled') == false) ||
            (config('settings.discuss.enabled') == false && Auth::user()->level() < 4)
        ) {
            return redirect()
                        ->route('page.index')
                        ->with('danger', 'Le système de discussion est temporairement désactivé.');
        }

        // If the discuss is disabled and the user is admin.
        if (config('settings.discuss.enabled') == false && Auth::user()->level() >= 4) {
            Session::flash('danger', 'Le système de discussion est actuellement désactivé.');
        }

        return $next($request);
    }
}
