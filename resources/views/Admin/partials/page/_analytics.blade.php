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
