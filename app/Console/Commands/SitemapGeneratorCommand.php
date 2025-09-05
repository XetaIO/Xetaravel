<?php

declare(strict_types=1);

namespace Xetaravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\Crawler;
use Throwable;

class SitemapGeneratorCommand extends Command
{
    protected $signature = 'sitemap:generator';

    protected $description = 'Generates XML sitemap and excludes irrelevant URLs.';

    public function handle(): void
    {
        $baseUrl = mb_rtrim((string) config('app.url'), '/');

        if ($baseUrl === '') {
            $this->error('app.url is not defined in your configuration/ENV. Set APP_URL and try again.');
            return;
        }

        $this->info("Generating the sitemap for: {$baseUrl}");

        // URL patterns to exclude (wildcards accepted)
        $excludePatterns = [
            $baseUrl . '/',
            $baseUrl . '/auth*',
            $baseUrl . '/login*',
            $baseUrl . '/register*',
            $baseUrl . '/logout*',
            $baseUrl . '/password/*',
            $baseUrl . '/email/*',
            $baseUrl . '/newsletter/*',
            $baseUrl . '/download/*',
            $baseUrl . '/banished/*',
            $baseUrl . '/contact*',
            $baseUrl . '/admin*',
            $baseUrl . '/_debugbar*',
            $baseUrl . '/debugbar*',
            $baseUrl . '/sitemap.xml',
            $baseUrl . '/rss*',
            $baseUrl . '/comment*',
            $baseUrl . '/users*',
            $baseUrl . '/discuss/post*',
        ];

        try {
            SitemapGenerator::create($baseUrl)
                ->configureCrawler(function (Crawler $crawler): void {
                    $crawler->setMaximumDepth(5);
                    $crawler->ignoreRobots();
                })
                ->hasCrawled(function (Url $url) use ($excludePatterns) {

                    if (Str::is($excludePatterns, $url->url)) {
                        return null;
                    }

                    // Avoid certain types of non-HTML resources
                    $path = (string) parse_url($url->url, PHP_URL_PATH);
                    if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg|ico|css|js|json|pdf|xml|txt|zip|rar)$/i', $path)) {
                        return null;
                    }

                    return Url::create($url->url)
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);
                })
                ->writeToFile(public_path('sitemap.xml'));

            $this->info('Sitemap generated successfully: public/sitemap.xml');
        } catch (Throwable $e) {
            $this->error('Error generating sitemap: ' . $e->getMessage());
        }
    }
}
