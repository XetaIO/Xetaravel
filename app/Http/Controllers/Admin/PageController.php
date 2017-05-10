<?php
namespace Xetaravel\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Rinvex\Country\CountryLoader;
use Spatie\Analytics\AnalyticsFacade;
use Spatie\Analytics\Period;

class PageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Visitors
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now()->subDay();
        $visitorsData = AnalyticsFacade::performQuery(
            Period::create($startDate, $endDate),
            'ga:sessions,ga:pageviews',
            [
                'dimensions' => 'ga:date',
                'sort' => 'ga:date'
            ]
        );

        $data = [];
        foreach ($visitorsData->rows as $row) {
            $row[0] = Carbon::createFromFormat('Ymd', $row[0]);

            array_push($data, $row);
        }
        $visitorsData->rows = array_reverse($data);

        // Browsers
        $startDate = Carbon::create(2014, 07, 01);
        $browsersData = AnalyticsFacade::performQuery(
            Period::create($startDate, $endDate),
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

        $data = [];
        foreach ($browsersData->rows as $browser) {
            $percent = round(($browser[1] * 100) / $browsersData->totalsForAllResults['ga:pageviews'], 1);

            switch ($browser[0]) {
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

            $browser[] = $percent;
            $browser[] = $color;

            array_push($data, $browser);
        }
        $browsersData->rows = array_reverse($data);

        // Countries
        $countriesData = AnalyticsFacade::performQuery(
            Period::create($startDate, $endDate),
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
                'percent' => round(($country[1] * 100) / $countriesData->totalsForAllResults['ga:pageviews'], 1)
            ];

            if (!in_array($country[0], ['ZZ'])) {
                $countryInstance = country((string)strtolower($country[0]));
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
        $topCountries = array_slice($countries, 0, 3);

        // Devices
        $startDate = Carbon::now()->subMonths(7);
        $devicesData = AnalyticsFacade::performQuery(
            Period::create($startDate, $endDate),
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

        // Operating System
        $startDate = Carbon::now()->subMonths(7);
        $operatingSystemData = AnalyticsFacade::performQuery(
            Period::create($startDate, $endDate),
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

        return view(
            'Admin::page.index',
            [
                'breadcrumbs' => $this->breadcrumbs,
                'visitorsData' => $visitorsData,
                'browsersData' => $browsersData,
                'countriesData' => $countriesData,
                'topCountries' => $topCountries,
                'devicesGraph' => $devicesGraph,
                'operatingSystemGraph' => $operatingSystemGraph
            ]
        );
    }
}
