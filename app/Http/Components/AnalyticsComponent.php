<?php
namespace Xetaravel\Http\Components;

use Carbon\Carbon;
use Spatie\Analytics\AnalyticsFacade;
use Spatie\Analytics\Period;

trait AnalyticsComponent
{
    /**
     * The and date used in Analytics requests.
     *
     * @var \Carbon\Carbon
     */
    protected $endDate;

    /**
     * Build the today visitors metric.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function buildTodayVisitors(): string
    {
        $startDate = Carbon::today();
        $endDate = Carbon::now();

        $visitorsData = AnalyticsFacade::performQuery(Period::create($startDate, $endDate), 'ga:users');

        return $visitorsData->totalsForAllResults['ga:users'];
    }

    /**
     * Build the today visitors metric.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function buildAllTimeVisitors(): string
    {
        $startDate = Carbon::createFromFormat('Y-m-d', config('analytics.start_date'));
        $endDate = Carbon::now();

        $visitorsData = AnalyticsFacade::performQuery(Period::create($startDate, $endDate), 'ga:sessions');

        return $visitorsData->totalsForAllResults['ga:sessions'];
    }

    /**
     * Build the visitors graph for the last 7 days.
     *
     * @codeCoverageIgnore
     *
     * @return \Google_Service_Analytics_GaData
     */
    public function buildVisitorsGraph(): \Google_Service_Analytics_GaData
    {
        $startDate = Carbon::now()->subDays(7);

        $visitorsData = AnalyticsFacade::performQuery(
            Period::create($startDate, $this->endDate),
            'ga:sessions,ga:pageviews',
            [
                'dimensions' => 'ga:date',
                'sort' => 'ga:date'
            ]
        );

        $visitorsGraph = [];
        foreach ($visitorsData->rows as $row) {
            $row[0] = Carbon::createFromFormat('Ymd', $row[0]);

            array_push($visitorsGraph, $row);
        }
        $visitorsData->rows = array_reverse($visitorsGraph);

        return $visitorsData;
    }

    /**
     * Build the browsers graph from the beginning.
     *
     * @codeCoverageIgnore
     *
     * @return \Google_Service_Analytics_GaData
     */
    public function buildBrowsersGraph(): \Google_Service_Analytics_GaData
    {
        $startDate = Carbon::createFromFormat('Y-m-d', config('analytics.start_date'));

        $browsersData = AnalyticsFacade::performQuery(
            Period::create($startDate, $this->endDate),
            'ga:pageviews',
            [
                'dimensions' => 'ga:browser',
                'sort' => 'ga:pageviews',
                'filters' => 'ga:browser==Chrome,'
                    .'ga:browser==Firefox,'
                    .'ga:browser==Internet Explorer,'
                    .'ga:browser==Safari,'
                    .'ga:browser==Opera'
            ]
        );

        $browsersGraph = [];
        foreach ($browsersData->rows as $browser) {
            $browser[] = $this->getPercentage($browser[1], $browsersData->totalsForAllResults['ga:pageviews']);
            $browser[] = $this->getBrowserColor($browser[0]);

            array_push($browsersGraph, $browser);
        }
        $browsersData->rows = array_reverse($browsersGraph);

        return $browsersData;
    }

    /**
     * Build the countries graph from the beginning.
     *
     * @codeCoverageIgnore
     *
     * @return \Google_Service_Analytics_GaData
     */
    public function buildCountriesGraph(): \Google_Service_Analytics_GaData
    {
        $startDate = Carbon::createFromFormat('Y-m-d', config('analytics.start_date'));

        $countriesData = AnalyticsFacade::performQuery(
            Period::create($startDate, $this->endDate),
            'ga:pageviews,ga:sessions',
            [
                'dimensions' => 'ga:countryIsoCode',
                'sort' => '-ga:pageviews'
            ]
        );

        foreach ($countriesData->rows as $country) {
            $countries[$country[0]] = [
                'ga:pageviews' => $country[1],
                'ga:sessions' => $country[2],
                'percent' => $this->getPercentage($country[1], $countriesData->totalsForAllResults['ga:pageviews'])
            ];

            if (!in_array($country[0], ['ZZ'])) {
                $countryInstance = country((string) strtolower($country[0]));
                $countries[$country[0]] += [
                    'countryName' => $countryInstance->getName()
                ];
            } else {
                $countries[$country[0]] += [
                    'countryName' => 'Unknown'
                ];
            }
        }
        $countriesData->rows = $countries;

        return $countriesData;
    }

    /**
     * Build the devices graph from the last 7 months.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function buildDevicesGraph(): string
    {
        $startDate = Carbon::now()->subMonths(7);

        $devicesData = AnalyticsFacade::performQuery(
            Period::create($startDate, $this->endDate),
            'ga:pageviews',
            [
                'dimensions' => 'ga:mobileDeviceBranding,ga:yearMonth',
                'sort' => '-ga:mobileDeviceBranding',
                'filters' => 'ga:mobileDeviceBranding==Apple,'
                    .'ga:mobileDeviceBranding==Samsung,'
                    .'ga:mobileDeviceBranding==Google,'
                    .'ga:mobileDeviceBranding==HTC,'
                    .'ga:mobileDeviceBranding==Microsoft'
            ]
        );

        $devicesGraph = [];
        for ($i = 0; $i < 8; $i++) {
            $date = Carbon::now()->subMonths($i);

            $devicesGraph[$date->format('Ym')] = [
                'period' => $date->format('Y-m-d'),
                'Apple' => 0,
                'Samsung' => 0,
                'Google' => 0,
                'HTC' => 0,
                'Microsoft' => 0
            ];
        }

        foreach ($devicesData->rows as $device) {
            $devicesGraph[$device[1]][$device[0]] = $device[2];
        }
        $devicesGraph = array_reverse($devicesGraph);
        $devicesGraph = collect($devicesGraph)->toJson();

        return $devicesGraph;
    }

    /**
     * Build the operating system graph from the last 7 months.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function buildOperatingSytemGraph(): string
    {
        $startDate = Carbon::now()->subMonths(7);

        $operatingSystemData = AnalyticsFacade::performQuery(
            Period::create($startDate, $this->endDate),
            'ga:pageviews',
            [
                'dimensions' => 'ga:operatingSystem,ga:yearMonth',
                'sort' => '-ga:operatingSystem',
                'filters' => 'ga:operatingSystem==Windows,'
                    .'ga:operatingSystem==Macintosh,'
                    .'ga:operatingSystem==Linux,'
                    .'ga:operatingSystem==(not set)'
            ]
        );

        $operatingSystemGraph = [];
        for ($i = 0; $i < 8; $i++) {
            $date = Carbon::now()->subMonths($i);

            $operatingSystemGraph[$date->format('Ym')] = [
                'period' => $date->format('Y-m-d'),
                'Windows' => 0,
                'Macintosh' => 0,
                'Linux' => 0,
                '(not set)' => 0
            ];
        }

        foreach ($operatingSystemData->rows as $os) {
            $operatingSystemGraph[$os[1]][$os[0]] = $os[2];
        }
        $operatingSystemGraph = array_reverse($operatingSystemGraph);
        $operatingSystemGraph = collect($operatingSystemGraph)->toJson();

        return $operatingSystemGraph;
    }

    /**
     * Get the percentage relative to the total page views.
     *
     * @param int $pageviews The page views.
     * @param int $total The total page views.
     *
     * @return float
     */
    public function getPercentage($pageviews, $total): float
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
    public function getBrowserColor(string $browser): string
    {
        switch ($browser) {
            case 'Chrome':
                $color = '#00acac';
                break;
            case 'Firefox':
                $color = '#f4645f';
                break;
            case 'Safari':
                $color = '#727cb6';
                break;
            case 'Opera':
                $color = '#348fe2';
                break;
            case 'Internet Explorer':
                $color = '#75e376';
                break;
            default:
                $color = '#ddd';
        }

        return $color;
    }
}
