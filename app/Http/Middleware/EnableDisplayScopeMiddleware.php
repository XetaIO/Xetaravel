<?php

namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Xetaravel\Models\Article;
use Xetaravel\Models\Scopes\DisplayScope;

class EnableDisplayScopeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Article::addGlobalScope(new DisplayScope);

        return $next($request);
    }
}
