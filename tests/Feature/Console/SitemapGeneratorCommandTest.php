<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;

class SitemapGeneratorCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_shows_error_when_app_url_missing(): void
    {
        Config::set('app.url', '');

        $exitCode = Artisan::call('sitemap:generator');
        $output = Artisan::output();

        $this->assertSame(0, $exitCode, 'Command should not crash.');
        $this->assertStringContainsString('app.url is not defined', $output);
    }

    public function test_handle_generates_sitemap_and_writes_file(): void
    {
        // Arrange
        $baseUrl = 'https://example.test';
        Config::set('app.url', $baseUrl);

        // Mock static call SitemapGenerator::create(...) via alias mocking
        $alias = 'alias:Spatie\\Sitemap\\SitemapGenerator';
        $sitemapGeneratorStatic = Mockery::mock($alias);

        $chainMock = Mockery::mock();
        $sitemapGeneratorStatic
            ->shouldReceive('create')
            ->once()
            ->with($baseUrl)
            ->andReturn($chainMock);

        // Chain: configureCrawler(callable) -> self
        $chainMock
            ->shouldReceive('configureCrawler')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return is_callable($arg);
            }))
            ->andReturnSelf();

        // Chain: hasCrawled(callable) -> self
        $chainMock
            ->shouldReceive('hasCrawled')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return is_callable($arg);
            }))
            ->andReturnSelf();

        // Final: writeToFile(public_path('sitemap.xml'))
        $chainMock
            ->shouldReceive('writeToFile')
            ->once()
            ->with(public_path('sitemap.xml'))
            ->andReturnNull();

        // Act
        $exitCode = Artisan::call('sitemap:generator');
        $output = Artisan::output();

        // Assert
        $this->assertSame(0, $exitCode);
        $this->assertStringContainsString("Generating the sitemap for: {$baseUrl}", $output);
        $this->assertStringContainsString('Sitemap generated successfully', $output);
    }
}
