<?php

declare(strict_types=1);

namespace Xetaravel\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PackagistVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null): mixed
    {
        $version = Cache::remember(
            'Packagist.version',
            config('xetaravel.site.packagist_cache_timeout'),
            function () {
                $client = new Client();
                try {
                    $res = $client->request('GET', config('xetaravel.site.packagist_url'));
                } catch (\GuzzleHttp\Exception\ConnectException) {
                    return false;
                }
                if ($res->getStatusCode() !== 200) {
                    return false;
                }

                $array = json_decode($res->getBody()->getContents(), true);

                return $array['packages']['xetaio/xetaravel'][0]['version'];
            }
        );

        config(['xetaravel.version' => $version]);

        return $next($request);
    }
}
