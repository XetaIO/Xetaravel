<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use MeShaon\RequestAnalytics\Services\DashboardAnalyticsService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Xetaravel\Http\Components\AnalyticsComponent;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class PageController extends Controller
{
    use AnalyticsComponent;

    public function __construct(protected DashboardAnalyticsService $dashboardService)
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return Factory|View|Application|\Illuminate\View\View|object
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Request $request)
    {
        $minutes = config('analytics.cache_lifetime_in_minutes');

        $viewDatas = [];

        if (!App::environment('testing') && settings('analytics_enabled')) {
            $mobileDevices = Cache::remember('Analytics.mobiles', $minutes, function () {
                return $this->buildDevicesGraph();
            });
            $viewDatas[] = 'mobileDevices';

            $yesterdayVisitors = Cache::remember('Analytics.yesterdayVisitors', $minutes, function () {
                return $this->buildYesterdayVisitors();
            });
            $viewDatas[] = 'yesterdayVisitors';
        }

        $usersCount = Cache::remember('Analytics.users.count', $minutes, function () {
            return User::count();
        });
        $viewDatas[] = 'usersCount';

        $blogArticlesCount = Cache::remember('Analytics.blog_articles.count', $minutes, function () {
            return BlogArticle::count();
        });
        $viewDatas[] = 'blogArticlesCount';

        $blogCommentsCount = Cache::remember('Analytics.blog_comments.count', $minutes, function () {
            return BlogComment::count();
        });
        $viewDatas[] = 'blogCommentsCount';

        $discussPostsCount = Cache::remember('Analytics.discuss_posts.count', $minutes, function () {
            return DiscussPost::count();
        });
        $viewDatas[] = 'discussPostsCount';

        $breadcrumbs = $this->breadcrumbs;
        $viewDatas[] = 'breadcrumbs';

        $params = [];

        if ($request->has('start_date') && $request->has('end_date')) {
            $params['start_date'] = $request->input('start_date');
            $params['end_date'] = $request->input('end_date');
        } else {
            $dateRangeInput = $request->input('date_range', 30);
            $dateRange = is_numeric($dateRangeInput) && (int) $dateRangeInput > 0
                ? (int) $dateRangeInput
                : 30;
            $params['date_range'] = $dateRange;
        }

        $params['request_category'] = $request->input('request_category', null);
        $data = $this->dashboardService->getDashboardData($params);

        return view(
            'Admin.page.index',
            compact($viewDatas),
            $data
        );
    }
}
