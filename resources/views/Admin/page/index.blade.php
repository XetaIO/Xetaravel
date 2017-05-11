@extends('layouts.admin')
{!! config(['app.title' => 'Dashboard']) !!}

@section('content')
<main class="col-sm-12 col-md-10 offset-md-2 p-2">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
            <div class="widget widget-stats bg-primary">
	            <div class="stats-icon">
                    <i class="fa fa-users fa-fw"></i>
                </div>
	            <div class="stats-title">
                    MEMBERS
                </div>
	            <div class="stats-number">
                    {{ $usersCount }}
                </div>
                <div class="stats-progress">
                </div>
                <small class="stats-desc">
                    The numbers of users registered since the beginning.
                </small>
	        </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
            <div class="widget widget-stats" style="background:#00acac;">
	            <div class="stats-icon">
                    <i class="fa fa-newspaper-o fa-fw"></i>
                </div>
	            <div class="stats-title">
                    ARTICLES
                </div>
	            <div class="stats-number">
                    {{ $articlesCount }}
                </div>
                <div class="stats-progress">
                </div>
                <small class="stats-desc">
                    The numbers of articles published since the beginning.
                </small>
	        </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
            <div class="widget widget-stats" style="background:#727cb6;">
	            <div class="stats-icon">
                    <i class="fa fa-comments-o fa-fw"></i>
                </div>
	            <div class="stats-title">
                    COMMENTS
                </div>
	            <div class="stats-number">
                    {{ $commentsCount }}
                </div>
                <div class="stats-progress">
                </div>
                <small class="stats-desc">
                    The numbers of comments created since the beginning.
                </small>
	        </div>
        </div>

        @if (config('analytics.enabled'))
            <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
                <div class="widget widget-stats" style="background:#348fe2;">
    	            <div class="stats-icon">
                        <i class="fa fa-globe fa-fw"></i>
                    </div>
    	            <div class="stats-title">
                        TODAY'S VISITS
                    </div>
    	            <div class="stats-number">
                        {{ $todayVisitors }}
                    </div>
                    <div class="stats-progress">
                    </div>
                    <small class="stats-desc">
                        The numbers of visits for today.
                    </small>
    	        </div>
            </div>
        @endif

    </div>
    @if (config('analytics.enabled'))
        @include('Admin::partials.page._analytics')
    @endif
</main>
@endsection
@if (config('analytics.enabled'))
    @include('Admin::partials.page._analytics-scripts')
@endif
