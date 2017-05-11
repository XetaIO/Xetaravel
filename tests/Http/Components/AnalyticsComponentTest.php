<?php
namespace Tests\Http\Components;

use Tests\TestCase;

class AnalyticsComponentTest extends TestCase
{
    /**
     * testGetPercentage method
     *
     * @return void
     */
    public function testGetPercentage()
    {
        $mock = $this->getMockForTrait('\Xetaravel\Http\Components\AnalyticsComponent');
        $this->assertSame(40.0, $mock->getPercentage(40, 100));
    }

    /**
     * testGetBrowserColor method
     *
     * @return void
     */
    public function testGetBrowserColor()
    {
        $mock = $this->getMockForTrait('\Xetaravel\Http\Components\AnalyticsComponent');
        $this->assertSame('#00acac', $mock->getBrowserColor('Chrome'));
        $this->assertSame('#f4645f', $mock->getBrowserColor('Firefox'));
        $this->assertSame('#727cb6', $mock->getBrowserColor('Safari'));
        $this->assertSame('#348fe2', $mock->getBrowserColor('Opera'));
        $this->assertSame('#75e376', $mock->getBrowserColor('Internet Explorer'));
        $this->assertSame('#ddd', $mock->getBrowserColor('unknown'));
    }
}
