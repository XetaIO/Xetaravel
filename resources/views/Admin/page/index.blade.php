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
                    7,842
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
                    42
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
                    169
                </div>
                <div class="stats-progress">
                </div>
                <small class="stats-desc">
                    The numbers of comments created since the beginning.
                </small>
	        </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
            <div class="widget widget-stats" style="background:#348fe2;">
	            <div class="stats-icon">
                    <i class="fa fa-globe fa-fw"></i>
                </div>
	            <div class="stats-title">
                    TODAY'S VISITS
                </div>
	            <div class="stats-number">
                    29
                </div>
                <div class="stats-progress">
                </div>
                <small class="stats-desc">
                    The numbers of visits for today.
                </small>
	        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-2">
            <div class="widget-chart bg-inverse">
                <div class="widget-chart-content">
                    <h4 class="chart-title">
                        Visitors Analytics
                        <small>See how many visitors and page views you got per day.</small>
                    </h4>
                    <div id="visitors-line-chart" style="height: 260px;"></div>
                </div>
                <div class="widget-chart-sidebar bg-black-darker">
	                <h4 class="chart-title">
	                    Browsers
	                    <small>Browsers statistics</small>
	                </h4>
	                <div id="browsers-donut-chart" style="height: 160px"></div>
	                <ul class="chart-legend">
                        @foreach ($browsersData->rows as $browser)
                            <li>
                                <i class="fa fa-circle-o fa-fw" style="color: {{ $browser[3] }}"></i>
                                {{ $browser[2] }}%
                                <span>
                                    {{ $browser[0] }}
                                </span>
                            </li>
                        @endforeach
	                </ul>
	            </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
	        <div class="widget-map widget-inverse" data-sortable-id="index-1">
	            <div class="stats-heading">
	                <h4 class="stats-title">
	                    Visitors Origin
	                </h4>
	            </div>
	            <div id="visitors-map" style="height: 181px;"></div>
	            <ul class="list-group">
                    @foreach ($topCountries as $country)
                        <li href="#" class="list-group-item list-group-item-inverse bg-inverse text-white">
                            <span class="tag tag-primary pull-right">{{ $country['percent'] }}%</span>
                            {{ $country['countryName'] }}
                        </li>
                    @endforeach
                </ul>
	        </div>
	    </div>

    </div>
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="widget-chart bg-inverse">
                <div class="widget-chart-content mr-0">
                    <h4 class="chart-title">
                        Device Branding Analytics
                        <small>Which mobile your visitors come from</small>
                    </h4>
                    <div id="devices-line-chart" class="morris-inverse" style="height: 260px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-2">
            <div class="widget-chart bg-inverse">
                <div class="widget-chart-content mr-0">
                    <h4 class="chart-title">
                        Operating System Analytics
                        <small>Which OS your visitors come from</small>
                    </h4>
                    <div id="operating-system-bar-chart" class="morris-inverse" style="height: 260px;"></div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript">

    // Visitors
    var visitorsData = [];
    @foreach ($visitorsData->rows as $row)
        visitorsData.push({
            x: "{{ $row[0]->toDateString() }}",
            y: {{ $row[1] }},
            z: {{ $row[2] }}
        });
    @endforeach

    // Browsers
    var browsersData = [];
    @foreach ($browsersData->rows as $browser)
        browsersData.push({
            label: "{{ $browser[0] }}",
            value: {{ $browser[1] }}
        });
    @endforeach

    // Countries
    var countriesData = [];
    @foreach ($countriesData->rows as $isoCode => $country)
        countriesData["{{ $isoCode }}"] = {{ $country['ga:pageviews'] }};
    @endforeach

    // Devices
    var devicesData = {!! $devicesGraph !!};

    // Operating System
    var operatingSystemData = {!! $operatingSystemGraph !!};

    VisitorsLineCharts(visitorsData);
    BrowsersDonutChart(browsersData);
    VisitorsVectorMap(countriesData);
    DevicesAreaChart(devicesData);
    OperatingSystemBarChart(operatingSystemData);

</script>
@endpush
