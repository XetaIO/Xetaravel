<?php

declare(strict_types=1);

namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\Scopes\PublishedScope;

class EnablePublishedScopeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     *
     * @return Response|RedirectResponse|BinaryFileResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|BinaryFileResponse
    {
        BlogArticle::addGlobalScope(new PublishedScope());

        return $next($request);
    }
}
