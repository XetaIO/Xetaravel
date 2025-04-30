<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Components;

use Tests\TestCase;
use Xetaravel\Http\Components\AnalyticsComponent;

class AnalyticsComponentTest extends TestCase
{
    use AnalyticsComponent;

    public function test_get_percentage()
    {
        $this->assertEquals(50.0, $this->getPercentage(50, 100));
        $this->assertEquals(0.0, $this->getPercentage(0, 100));
        $this->assertEquals(100.0, $this->getPercentage(100, 100));
        $this->assertEquals(33.3, $this->getPercentage(10, 30));
    }

    public function test_get_browser_color()
    {
        $this->assertEquals('#00acac', $this->getBrowserColor('Chrome'));
        $this->assertEquals('#f4645f', $this->getBrowserColor('Firefox'));
        $this->assertEquals('#727cb6', $this->getBrowserColor('Safari'));
        $this->assertEquals('#348fe2', $this->getBrowserColor('Opera'));
        $this->assertEquals('#75e376', $this->getBrowserColor('Edge'));
        $this->assertEquals('#ff3a01', $this->getBrowserColor('Brave'));
        $this->assertEquals('#ddd', $this->getBrowserColor('UnknownBrowser'));
    }
}
