<?php

declare(strict_types=1);

namespace Scripts;

use Composer\Script\Event;
use Dotenv\Dotenv;

final class EnsureRobotsSitemap
{
    private static function out(?Event $event, string $message): void
    {
        if ($event) {
            $event->getIO()->write($message);
        } else {
            fwrite(STDOUT, $message . PHP_EOL);
        }
    }
    /**
     * Point d'entrée pour les scripts Composer (post-install/post-update).
     */
    public static function runComposerScript(?Event $event = null): void
    {
        $projectRoot = dirname(__DIR__);
        self::run($projectRoot, $event);
    }

    /**
     * Peut être appelée manuellement (par ex. depuis un script ou Tinker).
     */
    public static function run(string $projectRoot, ?Event $event = null): void
    {
        // Load the .env if present
        if (is_file($projectRoot . '/.env')) {
            // Ensures autoload
            if (!class_exists(Dotenv::class) && is_file($projectRoot . '/vendor/autoload.php')) {
                require $projectRoot . '/vendor/autoload.php';
            }
            if (class_exists(Dotenv::class)) {
                $dotenv = Dotenv::createImmutable($projectRoot);
                $dotenv->safeLoad();
            }
        }

        $target = mb_rtrim($projectRoot, DIRECTORY_SEPARATOR) . '/public/robots.txt';

        // Reading variable via multiple sources + default value
        $sitemapUrl = $_ENV['APP_SITEMAPS']
            ?? $_SERVER['APP_SITEMAPS']
            ?? getenv('APP_SITEMAPS')
            ?: 'https://xetaravel.com/sitemap.xml';

        $sitemapLine = 'Sitemap: ' . $sitemapUrl;

        $dir = dirname($target);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        if (!file_exists($target)) {
            file_put_contents($target, $sitemapLine . PHP_EOL);
            self::out($event, "Created robots.txt with sitemap line.");
            return;
        }

        $contents = file_get_contents($target) ?: '';
        $lines = preg_split('/\r\n|\r|\n/', $contents);

        foreach ($lines as $line) {
            if (mb_trim($line) === $sitemapLine) {
                self::out($event, "Sitemap line already present.");
                return;
            }
        }

        if ($contents !== '' && !preg_match('/\R\z/', $contents)) {
            $contents .= PHP_EOL;
        }

        $contents .= $sitemapLine . PHP_EOL;
        file_put_contents($target, $contents);
        self::out($event, "Appended sitemap line to robots.txt.");
    }
}
