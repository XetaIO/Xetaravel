<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Xetaravel\Http\Components\AnalyticsComponent;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\User;

class PageController extends Controller
{
    use AnalyticsComponent;

    /**
     * Show the application dashboard.
     *
     * @return Factory|View|Application|\Illuminate\View\View|object
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        $minutes = config('analytics.cache_lifetime_in_minutes');

        $viewDatas = [];

        if (!App::environment('testing') && settings('analytics_enabled')) {

            $visitorsData = Cache::remember('Analytics.visitors', $minutes, function () {
                return $this->buildVisitorsGraph();
            });
            $viewDatas[] = 'visitorsData';

            $browsersData = Cache::remember('Analytics.browsers', $minutes, function () {
                return $this->buildBrowsersGraph();
            });
            $viewDatas[] = 'browsersData';

            $devicesGraph = Cache::remember('Analytics.devices', $minutes, function () {
                return $this->buildDevicesGraph();
            });
            $viewDatas[] = 'devicesGraph';

            $operatingSystemGraph = Cache::remember('Analytics.operatingsystem', $minutes, function () {
                return $this->buildOperatingSystemGraph();
            });
            $viewDatas[] = 'operatingSystemGraph';

            $yesterdayVisitors = Cache::remember('Analytics.yesterdayvisitors', $minutes, function () {
                return $this->buildTodayVisitors();
            });
            $viewDatas[] = 'yesterdayVisitors';
        }

        $usersCount = Cache::remember('Analytics.users.count', $minutes, function () {
            return User::count();
        });
        $viewDatas[] = 'usersCount';

        $articlesCount = Cache::remember('Analytics.articles.count', $minutes, function () {
            return BlogArticle::count();
        });
        $viewDatas[] = 'articlesCount';

        $commentsCount = Cache::remember('Analytics.comments.count', $minutes, function () {
            return BlogComment::count();
        });
        $viewDatas[] = 'commentsCount';

        $breadcrumbs = $this->breadcrumbs;
        $viewDatas[] = 'breadcrumbs';

        return view(
            'Admin.page.index',
            compact($viewDatas)
        );
    }
}
