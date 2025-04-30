<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Components;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Tests\TestCase;

class AnalyticsComponentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::create(2024, 4, 30));
    }

    public function test_build_browsers_graph()
    {
        config(['analytics.start_date' => '2023-01-01']);

        Analytics::shouldReceive('get')
            ->once()
            ->andReturn(collect([
                ['browser' => 'Chrome', 'screenPageViews' => 100],
                ['browser' => 'Firefox', 'screenPageViews' => 50],
            ]));

        $component = new FakeAnalyticsComponent();
        $result = $component->buildBrowsersGraph();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals('Chrome', $result[0]['browser']);
        $this->assertEquals('#00acac', $result[0]['color']);
        $this->assertEquals(66.7, $result[0]['percentage']);
        $this->assertEquals(100, $result[0]['screenPageViews']);

        $this->assertEquals('Firefox', $result[1]['browser']);
        $this->assertEquals(33.3, $result[1]['percentage']);
    }

    public function test_build_devices_graph()
    {
        Analytics::shouldReceive('get')
            ->once()
            ->andReturn(collect([
                ['mobileDeviceBranding' => 'Apple', 'yearMonth' => '202310', 'screenPageViews' => 120],
                ['mobileDeviceBranding' => 'Samsung', 'yearMonth' => '202311', 'screenPageViews' => 60],
            ]));

        $component = new FakeAnalyticsComponent();
        $result = $component->buildDevicesGraph();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertArrayHasKey('Apple', $result->first());
        $this->assertArrayHasKey('Samsung', $result->first());
        $this->assertArrayHasKey('HTC', $result->first());
        $this->assertIsInt($result->first()['Apple']);
    }

    public function test_build_operating_system_graph()
    {
        Analytics::shouldReceive('get')
            ->once()
            ->andReturn(collect([
                ['operatingSystem' => 'Windows', 'yearMonth' => '202310', 'screenPageViews' => 150],
                ['operatingSystem' => 'Linux', 'yearMonth' => '202311', 'screenPageViews' => 80],
            ]));

        $component = new FakeAnalyticsComponent();
        $result = $component->buildOperatingSystemGraph();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertArrayHasKey('Windows', $result->first());
        $this->assertArrayHasKey('Macintosh', $result->first());
        $this->assertArrayHasKey('Linux', $result->first());
        $this->assertIsInt($result->first()['Linux']);
    }

    public function test_build_visitors_graph()
    {
        $now = Carbon::create(2024, 4, 30);
        Carbon::setTestNow($now);

        Analytics::shouldReceive('get')
            ->once()
            ->withArgs(function ($period, $metrics, $dimensions, $limit, $orderBy) use ($now) {
                $this->assertEquals(['sessions', 'screenPageViews'], $metrics);
                $this->assertEquals(['date'], $dimensions);
                $this->assertInstanceOf(Period::class, $period);
                $this->assertEquals($now->toDateString(), $period->endDate->toDateString());
                $this->assertEquals($now->subDays(7)->startOfDay()->toDateString(), $period->startDate->toDateString());
                return true;
            })
            ->andReturn(collect([
                ['date' => Carbon::parse('2024-04-29'), 'sessions' => 10, 'screenPageViews' => 25],
                ['date' => Carbon::parse('2024-04-30'), 'sessions' => 15, 'screenPageViews' => 30],
            ]));

        $component = new FakeAnalyticsComponent();
        $result = $component->buildVisitorsGraph();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertEquals('2024-04-30', $result->first()['date']);
        $this->assertEquals(15, $result->first()['sessions']);
        $this->assertEquals(30, $result->first()['screenPageViews']);
    }

    public function test_build_yesterday_visitors()
    {
        $now = Carbon::create(2024, 4, 30);
        Carbon::setTestNow($now);

        $expectedStart = $now->copy()->subDay()->startOfDay();
        $expectedEnd = $now->copy()->subDay()->endOfDay();

        Analytics::shouldReceive('get')
            ->once()
            ->withArgs(function ($period, $metrics, $dimensions) use ($expectedStart, $expectedEnd) {
                $this->assertEquals(['screenPageViews'], $metrics);
                $this->assertEquals(['year'], $dimensions);
                $this->assertEquals($expectedStart->toDateTimeString(), $period->startDate->toDateTimeString());
                $this->assertEquals($expectedEnd->toDateTimeString(), $period->endDate->toDateTimeString());
                return true;
            })
            ->andReturn(collect([
                ['year' => 2024, 'screenPageViews' => 123],
            ]));

        $component = new FakeAnalyticsComponent();
        $result = $component->buildYesterdayVisitors();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(123, $result[0]['screenPageViews']);
        $this->assertEquals(2024, $result[0]['year']);
    }
}
