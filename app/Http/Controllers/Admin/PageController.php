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

        if (config('analytics.enabled')) {
            // @codeCoverageIgnoreStart
            $visitorsData = Cache::remember('Analytics.visitors', $minutes, function () {
                return $this->buildVisitorsGraph();
            });

            $browsersData = Cache::remember('Analytics.browsers', $minutes, function () {
                return $this->buildBrowsersGraph();
            });

            $countriesData = Cache::remember('Analytics.countries', $minutes, function () {
                return $this->buildCountriesGraph();
            });

            $devicesGraph = Cache::remember('Analytics.devices', $minutes, function () {
                return $this->buildDevicesGraph();
            });

            $topCountries = array_slice($countriesData->rows, 0, 3);

            $operatingSystemGraph = Cache::remember('Analytics.operatingsystem', $minutes, function () {
                return $this->buildOperatingSytemGraph();
            });

            $todayVisitors = Cache::remember('Analytics.todayvisitors', $minutes, function () {
                return $this->buildTodayVisitors();
            });
            // @codeCoverageIgnoreEnd
        }

        $usersCount = Cache::remember('Analytics.users.count', $minutes, function () {
            return User::count();
        });

        $articlesCount = Cache::remember('Analytics.articles.count', $minutes, function () {
            return Article::count();
        });

        $commentsCount = Cache::remember('Analytics.comments.count', $minutes, function () {
            return Comment::count();
        });

        $breadcrumbs = $this->breadcrumbs;

        return view(
            'Admin::page.index',
            compact(
                'breadcrumbs',
                'visitorsData',
                'browsersData',
                'countriesData',
                'topCountries',
                'devicesGraph',
                'operatingSystemGraph',
                'usersCount',
                'articlesCount',
                'commentsCount',
                'todayVisitors'
            )
        );
    }
}
