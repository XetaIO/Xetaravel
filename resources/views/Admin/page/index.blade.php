@extends('layouts.admin')
{!! config(['app.title' => 'Dashboard']) !!}

@push('meta')
    <x-meta title="Dashboard" />
@endpush

@section('content')
<section class="m-3 lg:m-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl mb-2">
                <x-icon name="fas-chart-line" class="h-6 w-6 mr-2" />
                Dashboard
            </h1>
            <p class="text-sm text-gray-500">Website performance and user insights</p>
        </div>
        <div class="w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.page.index') }}" class="flex items-center gap-2 flex-wrap">
                <select name="date_range" class="bg-base-100 dark:bg-base-300 rounded-lg shadow-md px-3 py-2.5 pr-6 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-primary h-10">
                    <option value="7" {{ $dateRange == 7 ? 'selected' : '' }}>Last 7 days</option>
                    <option value="30" {{ $dateRange == 30 ? 'selected' : '' }}>Last 30 days</option>
                    <option value="90" {{ $dateRange == 90 ? 'selected' : '' }}>Last 90 days</option>
                    <option value="365" {{ $dateRange == 365 ? 'selected' : '' }}>Last year</option>
                </select>
                <select name="request_category" class="bg-base-100 dark:bg-base-300 rounded-lg shadow-md px-3 py-2.5 pr-6 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-primary h-10">
                    <option value="" {{ !request('request_category') ? 'selected' : '' }}>All Requests</option>
                    <option value="web" {{ request('request_category') == 'web' ? 'selected' : '' }}>Web Only</option>
                    <option value="api" {{ request('request_category') == 'api' ? 'selected' : '' }}>API Only</option>
                </select>
                <button type="submit" class="btn btn-primary">Apply</button>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-primary text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Members
                    </div>
                    <div>
                        <x-icon name="fas-users" class="h-8 w-8 opacity-50" />
                    </div>
                </div>

                <div class="text-4xl font-bold">
                    {{ $usersCount }}
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-[color:#00acac] text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Blog Articles
                    </div>
                    <div>
                        <x-icon name="far-newspaper" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $blogArticlesCount }}
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-[color:#727cb6] text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Blog Comments
                    </div>
                    <div>
                        <x-icon name="far-message" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $blogCommentsCount }}
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-[color:#348fe2] text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Discuss Posts
                    </div>
                    <div>
                        <x-icon name="far-comments" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $discussPostsCount }}
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-base-100 dark:bg-base-300 shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Average Views
                    </div>
                    <div>
                        <x-icon name="far-eye" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $average["views"] }}
                </div>
            </div>
        </div>

        @if (!App::environment('testing') && settings('analytics_enabled'))
            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="p-6 rounded-lg bg-base-100 dark:bg-base-300 shadow-md h-full">
                    <div class="flex justify-between">
                        <div class="text-1xl uppercase">
                            Yesterday's visits
                        </div>
                        <div>
                            <x-icon name="fas-users-rectangle" class="h-8 w-8 opacity-50" />
                        </div>
                    </div>
                    <div class="text-4xl font-bold">
                    @if($yesterdayVisitors->first())
                        {{ $yesterdayVisitors->first()['screenPageViews'] }}
                    @else
                        0
                    @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="p-6 rounded-lg bg-base-100 dark:bg-base-300 shadow-md h-full">
                    <div class="flex justify-between">
                        <div class="text-1xl uppercase">
                            Average Visitors
                        </div>
                        <div>
                            <x-icon name="fas-users-rectangle" class="h-8 w-8 opacity-50" />
                        </div>
                    </div>
                    <div class="text-4xl font-bold">
                        {{ $average["visitors"] }}
                    </div>
                </div>
            </div>
        @endif

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-base-100 dark:bg-base-300 shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Bounce Rate
                    </div>
                    <div>
                        <x-icon name="fas-sign-out-alt" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $average["bounce_rate"] }}
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-base-100 dark:bg-base-300 shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-1xl uppercase">
                        Average Visit Time
                    </div>
                    <div>
                        <x-icon name="fas-clock" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $average["average_visit_time"] }}
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.stats.chart :labels='$labels' :datasets='$datasets' type="line"/>
        </div>
        <div class="col-span-12 lg:col-span-6 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.broswers :browsers='$browsers'/>
        </div>
        <div class="col-span-12 lg:col-span-6 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.operating-systems :operatingSystems='$operatingSystems'/>
        </div>
        <div class="col-span-12 lg:col-span-6 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.devices :devices='$devices'/>
        </div>
        <div class="col-span-12 lg:col-span-6 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.countries :countries='$countries'/>
        </div>
        <div class="col-span-12 lg:col-span-6 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.pages :pages='$pages'/>
        </div>
        <div class="col-span-12 lg:col-span-6 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <x-Admin::analytics.referrers :referrers='$referrers'/>
        </div>
    </div>

    @if (!App::environment('testing') && settings('analytics_enabled'))
        @include('Admin::partials.page._analytics')

        @include('Admin::partials.page._analytics-scripts')
    @endif

</section>
@endsection
