<?php

declare(strict_types=1);

namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
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
        // If discuss is disabled and the user is not admin.
        if ((!Auth::user() && !settings('discuss_enabled')) ||
            (!settings('discuss_enabled') && !Auth::user()->hasPermissionTo('manage discuss conversation'))
        ) {
            return redirect()
                        ->route('page.index')
                        ->error('The discuss system is temporarily disabled.');
        }

        // If discuss is disabled and the user is admin.
        if (!settings('discuss_enabled') && Auth::user()->hasPermissionTo('manage discuss conversation')) {
            Toaster::error('The discuss system is temporarily disabled.');
        }

        return $next($request);
    }
}
