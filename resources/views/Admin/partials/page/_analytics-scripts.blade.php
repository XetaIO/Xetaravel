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
