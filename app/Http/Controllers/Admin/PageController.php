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
        $secondes = config('analytics.cache_lifetime_in_secondes');

        $viewDatas = [];

        if (config('analytics.enabled')) {
            // @codeCoverageIgnoreStart
            $visitorsData = Cache::remember('Analytics.visitors', $secondes, function () {
                return $this->buildVisitorsGraph();
            });
            array_push($viewDatas, 'visitorsData');

            $browsersData = Cache::remember('Analytics.browsers', $secondes, function () {
                return $this->buildBrowsersGraph();
            });
            array_push($viewDatas, 'browsersData');

            $countriesData = Cache::remember('Analytics.countries', $secondes, function () {
                return $this->buildCountriesGraph();
            });
            array_push($viewDatas, 'countriesData');

            $devicesGraph = Cache::remember('Analytics.devices', $secondes, function () {
                return $this->buildDevicesGraph();
            });
            array_push($viewDatas, 'devicesGraph');

            $topCountries = array_slice($countriesData->rows, 0, 3);
            array_push($viewDatas, 'topCountries');

            $operatingSystemGraph = Cache::remember('Analytics.operatingsystem', $secondes, function () {
                return $this->buildOperatingSytemGraph();
            });
            array_push($viewDatas, 'operatingSystemGraph');

            $todayVisitors = Cache::remember('Analytics.todayvisitors', $secondes, function () {
                return $this->buildTodayVisitors();
            });
            array_push($viewDatas, 'todayVisitors');
            // @codeCoverageIgnoreEnd
        }

        $usersCount = Cache::remember('Analytics.users.count', $secondes, function () {
            return User::count();
        });
        array_push($viewDatas, 'usersCount');

        $articlesCount = Cache::remember('Analytics.articles.count', $secondes, function () {
            return Article::count();
        });
        array_push($viewDatas, 'articlesCount');

        $commentsCount = Cache::remember('Analytics.comments.count', $secondes, function () {
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
