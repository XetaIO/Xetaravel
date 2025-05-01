<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class DownloadsControllerTest extends TestCase
{
    protected string $testFilePath;
    protected string $testFileName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testFileName = 'test-file.txt';
        $this->testFilePath = public_path('files/' . $this->testFileName);

        if (!file_exists(dirname($this->testFilePath))) {
            mkdir(dirname($this->testFilePath), 0777, true);
        }

        file_put_contents($this->testFilePath, 'Test file content');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function test_download_returns_file_response()
    {
        $response = $this->get(route('downloads.show', ['file' => $this->testFileName]));

        $response->assertOk();
        $response->assertHeader('content-disposition', 'attachment; filename=' . $this->testFileName);
        $this->assertEquals('Test file content', file_get_contents($this->testFilePath));
    }

    public function test_download_returns_404_if_file_not_found()
    {
        $response = $this->get(route('downloads.show', ['file' => 'non-existent.txt']));

        $response->assertNotFound();
        $response->assertSee('404');
    }
}
