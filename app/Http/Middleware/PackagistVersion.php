<?php

declare(strict_types=1);

namespace Xetaravel\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class PackagistVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $client = new Client();

        $version = Cache::remember(
            'Packagist.version',
            config('xetaravel.site.packagist_cache'),
            function () use ($client) {
                $res = $client->request('GET', config('xetaravel.site.packagist_url'));
                if ($res->getStatusCode() !== 200) {
                    return false;
                }

                $array = json_decode($res->getBody(), true);

                return $array['packages']['xetaio/xetaravel'][0]['version'];
            }
        );

        config(['xetaravel.version' => $version]);

        return $next($request);
    }
}
