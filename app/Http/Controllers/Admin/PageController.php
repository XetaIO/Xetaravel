<?php
namespace Xetaravel\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Xetaravel\Http\Components\AnalyticsComponent;
use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;
use Xetaravel\Models\User;

class PageController extends Controller
{
    use AnalyticsComponent;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->endDate = Carbon::now()->subDay();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $minutes = config('analytics.cache_lifetime_in_minutes');

        $viewDatas = [];

        if (config('analytics.enabled')) {
            // @codeCoverageIgnoreStart
            $visitorsData = Cache::remember('Analytics.visitors', $minutes, function () {
                return $this->buildVisitorsGraph();
            });
            array_push($viewDatas, 'visitorsData');

            $browsersData = Cache::remember('Analytics.browsers', $minutes, function () {
                return $this->buildBrowsersGraph();
            });
            array_push($viewDatas, 'browsersData');

            $countriesData = Cache::remember('Analytics.countries', $minutes, function () {
                return $this->buildCountriesGraph();
            });
            array_push($viewDatas, 'countriesData');

            $devicesGraph = Cache::remember('Analytics.devices', $minutes, function () {
                return $this->buildDevicesGraph();
            });
            array_push($viewDatas, 'devicesGraph');

            $topCountries = array_slice($countriesData->rows, 0, 3);
            array_push($viewDatas, 'topCountries');

            $operatingSystemGraph = Cache::remember('Analytics.operatingsystem', $minutes, function () {
                return $this->buildOperatingSytemGraph();
            });
            array_push($viewDatas, 'operatingSystemGraph');

            $todayVisitors = Cache::remember('Analytics.todayvisitors', $minutes, function () {
                return $this->buildTodayVisitors();
            });
            array_push($viewDatas, 'todayVisitors');
            // @codeCoverageIgnoreEnd
        }

        $usersCount = Cache::remember('Analytics.users.count', $minutes, function () {
            return User::count();
        });
        array_push($viewDatas, 'usersCount');

        $articlesCount = Cache::remember('Analytics.articles.count', $minutes, function () {
            return Article::count();
        });
        array_push($viewDatas, 'articlesCount');

        $commentsCount = Cache::remember('Analytics.comments.count', $minutes, function () {
            return Comment::count();
        });
        array_push($viewDatas, 'commentsCount');

        $breadcrumbs = $this->breadcrumbs;
        array_push($viewDatas, 'breadcrumbs');

        return view(
            'Admin::page.index',
            compact($viewDatas)
        );
    }
}
