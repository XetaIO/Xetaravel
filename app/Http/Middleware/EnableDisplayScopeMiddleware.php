<?php

declare(strict_types=1);

namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\Scopes\DisplayScope;

class EnableDisplayScopeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        BlogArticle::addGlobalScope(new DisplayScope());

        return $next($request);
    }
}
