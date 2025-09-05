<?php

declare(strict_types=1);

namespace Tests\Scripts\Unit;

use PHPUnit\Framework\TestCase;
use Scripts\EnsureRobotsSitemap;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class EnsureRobotsSitemapTest extends TestCase
{
    private string $tmpRoot;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tmpRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'robots_' . bin2hex(random_bytes(6));
        mkdir($this->tmpRoot, 0777, true);

        // Reset env to a clean state between tests
        $this->unsetAppSitemapsEnv();
    }

    protected function tearDown(): void
    {
        $this->unsetAppSitemapsEnv();
        $this->rrmdir($this->tmpRoot);
        parent::tearDown();
    }

    private function unsetAppSitemapsEnv(): void
    {
        putenv('APP_SITEMAPS'); // unset
        unset($_ENV['APP_SITEMAPS'], $_SERVER['APP_SITEMAPS']);
    }

    private function setAppSitemapsEnv(string $value): void
    {
        putenv('APP_SITEMAPS=' . $value);
        $_ENV['APP_SITEMAPS'] = $value;
        $_SERVER['APP_SITEMAPS'] = $value;
    }

    private function rrmdir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $ri = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($ri as $file) {
            $file->isDir() ? rmdir($file->getPathname()) : @unlink($file->getPathname());
        }
        @rmdir($dir);
    }

    private function robotsPath(): string
    {
        return $this->tmpRoot . '/public/robots.txt';
    }

    public function test_it_creates_file_when_absent_using_env_variable(): void
    {
        $url = 'https://example.test/sitemap.xml';
        $this->setAppSitemapsEnv($url);

        EnsureRobotsSitemap::run($this->tmpRoot, null);

        $this->assertFileExists($this->robotsPath());
        $content = file_get_contents($this->robotsPath());
        $this->assertSame("Sitemap: {$url}" . PHP_EOL, $content);
    }

    public function test_it_appends_line_when_missing_in_existing_file(): void
    {
        $url = 'https://example.test/sitemap.xml';
        $this->setAppSitemapsEnv($url);

        // Prepare an existing robots.txt without the sitemap line and without trailing newline
        $path = $this->robotsPath();
        @mkdir(dirname($path), 0777, true);
        file_put_contents($path, "User-agent: *" . PHP_EOL . "Disallow: /private");

        EnsureRobotsSitemap::run($this->tmpRoot, null);

        $content = file_get_contents($path);
        $this->assertStringContainsString("User-agent: *" . PHP_EOL . "Disallow: /private" . PHP_EOL . "Sitemap: {$url}" . PHP_EOL, $content);
    }

    public function test_it_is_idempotent_when_line_already_present(): void
    {
        $url = 'https://example.test/sitemap.xml';
        $this->setAppSitemapsEnv($url);

        EnsureRobotsSitemap::run($this->tmpRoot, null);
        $first = file_get_contents($this->robotsPath());

        // Run again; content must remain strictly identical (no duplicate)
        EnsureRobotsSitemap::run($this->tmpRoot, null);
        $second = file_get_contents($this->robotsPath());

        $this->assertSame($first, $second);
        $this->assertSame("Sitemap: {$url}" . PHP_EOL, $second);
    }

    public function test_it_reads_from_dotenv_when_env_is_not_set(): void
    {
        // Create a .env with APP_SITEMAPS
        $dotenvValue = 'https://from-dotenv.test/sitemap.xml';
        file_put_contents($this->tmpRoot . '/.env', "APP_SITEMAPS={$dotenvValue}\n");

        EnsureRobotsSitemap::run($this->tmpRoot, null);

        $this->assertFileExists($this->robotsPath());
        $content = file_get_contents($this->robotsPath());
        $this->assertSame("Sitemap: {$dotenvValue}" . PHP_EOL, $content);
    }
}
