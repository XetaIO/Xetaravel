<?php

declare(strict_types=1);

namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DiscussMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return RedirectResponse|mixed
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // If the discuss is disabled and the user is not admin.
        if ((!Auth::user() && !settings('discuss_enabled')) ||
            (!settings('discuss_enabled') && Auth::user()->level() < 4)
        ) {
            return redirect()
                        ->route('page.index')
                        ->error('Le système de discussion est temporairement désactivé. ');
        }

        // If the discuss is disabled and the user is admin.
        if (!settings('discuss_enabled') && Auth::user()->level() >= 100) {
            Session::flash('error', 'Le système de discussion est actuellement désactivé.');
        }

        return $next($request);
    }
}
