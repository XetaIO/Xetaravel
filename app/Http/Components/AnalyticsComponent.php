<?php

declare(strict_types=1);

namespace Xetaravel\Http\Components;

use Carbon\Carbon;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\FilterExpression;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait AnalyticsComponent
{
    /**
     * Get the percentage relative to the total page views.
     *
     * @param int $pageviews The page views.
     * @param int $total The total page views.
     *
     * @return float
     */
    protected function getPercentage(int $pageviews, int $total): float
    {
        $percentage = ($pageviews * 100) / $total;

        return round($percentage, 1);
    }

    /**
     * Get the browser color by his name
     *
     * @param string $browser The name of the browser.
     *
     * @return string
     */
    protected function getBrowserColor(string $browser): string
    {
        return match ($browser) {
            'Chrome' => '#00acac',
            'Firefox' => '#f4645f',
            'Safari' => '#727cb6',
            'Opera' => '#348fe2',
            'Edge' => '#75e376',
            'Brave' => '#ff3a01',
            default => '#ddd',
        };
    }
    /**
     * Build the yesterday visitors metric.
     *
     * @return Collection
     */
    public function buildYesterdayVisitors(): Collection
    {
        $startDate = Carbon::yesterday()->startOfDay();
        $endDate = Carbon::now();

        return Analytics::get(Period::create($startDate, $endDate), ['screenPageViews'], ['year']);
    }

    /**
     * Build the visitors graph for the last 7 days.
     *
     * @codeCoverageIgnore
     *
     * @return Collection
     */
    public function buildVisitorsGraph(): Collection
    {
        $startDate = Carbon::now()->subDays(7);

        $visitorsData = Analytics::get(
            Period::create($startDate, Carbon::now()),
            ['sessions', 'screenPageViews'],
            ['date'],
            10,
            [OrderBy::dimension('date', true)]
        );

        $visitorsData = $visitorsData->map(function ($item) {
            $item['date'] = $item['date']->format('Y-m-d');
            return $item;
        });

        return $visitorsData->reverse();
    }

    /**
     * Build the browser graph from the beginning.
     *
     * @codeCoverageIgnore
     *
     * @return Collection
     */
    public function buildBrowsersGraph(): Collection
    {
        $startDate = Carbon::createFromFormat('Y-m-d', config('analytics.start_date'));

        $browsers = ['Chrome', 'Firefox', 'Edge', 'Safari', 'Opera', 'Brave'];

        $dimensionFilter = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'browser',
                'in_list_filter' => new Filter\InListFilter([
                    'values' => $browsers,
                ]),
            ]),
        ]);

        $browsersData = collect(Analytics::get(
            Period::create($startDate, Carbon::now()),
            ['screenPageViews'],
            ['browser'],
            10,
            [],
            0,
            $dimensionFilter,
            true
        ))->keyBy('browser');

        $totalViews = $browsersData->sum('screenPageViews');

        return collect($browsers)->map(function ($browser) use ($browsersData, $totalViews) {
            $screenPageViews = $browsersData[$browser]['screenPageViews'] ?? 0;

            return [
                'browser' => $browser,
                'color' => $this->getBrowserColor($browser),
                'percentage' => $this->getPercentage($screenPageViews, $totalViews),
                'screenPageViews' => $screenPageViews,
            ];
        });
    }

    /**
     * Build the devices graph from the last 7 months.
     *
     * @return Collection
     */
    public function buildDevicesGraph(): Collection
    {
        $startDate = Carbon::now()->subMonths(7);

        $devices = ['Apple', 'Samsung', 'HTC', 'Huawei', 'Microsoft'];

        $dimensionFilter = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'mobileDeviceBranding',
                'in_list_filter' => new Filter\InListFilter([
                    'values' => $devices,
                ]),
            ]),
        ]);

        $devicesData = Analytics::get(
            Period::create($startDate, Carbon::now()),
            ['screenPageViews'],
            ['mobileDeviceBranding', 'yearMonth'],
            10,
            [OrderBy::dimension('mobileDeviceBranding', true)],
            0,
            $dimensionFilter,
            true
        )->keyBy(fn ($item) => $item['yearMonth'] . '-' . $item['mobileDeviceBranding']);

        $devicesGraph = collect();
        foreach (range(0, 7) as $i) {
            $date = Carbon::now()->subMonths($i);

            $devicesGraph->put($date->format('Ym'), [
                'period' => $date->format('Y-m'),
                'Apple' => 0,
                'Samsung' => 0,
                'Google' => 0,
                'HTC' => 0,
                'Huawei' => 0,
                'Microsoft' => 0
            ]);
        }

        $devicesGraph = $devicesGraph->map(function ($row, $yearMonth) use ($devicesData, $devices) {
            foreach ($devices as $device) {
                $key = $yearMonth . '-' . $device;
                $row[$device] = $devicesData[$key]['screenPageViews'] ?? 0;
            }
            return $row;
        });

        return $devicesGraph->reverse();
    }

    /**
     * Build the operating system graph from the last 7 months.
     *
     * @return Collection
     */
    public function buildOperatingSystemGraph(): Collection
    {
        $startDate = Carbon::now()->subMonths(7);

        $operatingSystems = ['Windows', 'Linux', 'Macintosh'];

        $dimensionFilter = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'operatingSystem',
                'in_list_filter' => new Filter\InListFilter([
                    'values' => $operatingSystems,
                ]),
            ]),
        ]);

        $operatingSystemData = Analytics::get(
            Period::create($startDate, Carbon::now()),
            ['screenPageViews'],
            ['operatingSystem', 'yearMonth'],
            10,
            [OrderBy::dimension('operatingSystem', true)],
            0,
            $dimensionFilter,
            true
        )->keyBy(fn ($item) => $item['yearMonth'] . '-' . $item['operatingSystem']);

        $operatingSystemGraph = collect();
        foreach (range(0, 7) as $i) {
            $date = Carbon::now()->subMonths($i);

            $operatingSystemGraph->put($date->format('Ym'), [
                'period' => $date->format('Y-m'),
                'Windows' => 0,
                'Macintosh' => 0,
                'Linux' => 0,
            ]);
        }

        $operatingSystemGraph = $operatingSystemGraph->map(function ($row, $yearMonth) use ($operatingSystemData, $operatingSystems) {
            foreach ($operatingSystems as $os) {
                $key = $yearMonth . '-' . $os;
                $row[$os] = $operatingSystemData[$key]['screenPageViews'] ?? 0;
            }
            return $row;
        });

        return $operatingSystemGraph->reverse();
    }
}
