@push('scripts')
<script type="text/javascript">

    // Visitors
    var visitorsData = [];
    var dataset1 = [];
    var dataset2 = [];
    @foreach($visitorsData->rows as $row)
        visitorsData.push("{{ $row[0]->toDateString() }}");
        dataset1.push("{{ $row[1] }}");
        dataset2.push("{{ $row[2] }}");
    @endforeach

    new Chart(
        document.getElementById('visitors'),
        {
        type: 'line',
        data: {
            labels: visitorsData,
            datasets: [
                {
                    label: 'Visitors',
                    data: dataset1
                },
                {
                    label: 'Page Views',
                    data: dataset2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
        }
    );

    // Browsers
    var browsersLabels = [];
    var browsersData = [];
    var browsersColors = [];
    @foreach ($browsersData->rows as $browser)
        browsersLabels.push("{{ $browser[0] }}");
        browsersData.push("{{ $browser[1] }}");
        browsersColors.push("{{ $browser[3] }}");
    @endforeach

    new Chart(
        document.getElementById('browsers'),
        {
        type: 'doughnut',
        data: {
            labels: browsersLabels,
            datasets: [
                {
                    label: 'Browsers',
                    data: browsersData,
                    backgroundColor: browsersColors
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
        }
    );

    // Mobiles Devices
    var devicesLabels = [];
    var devicesApple = [];
    var devicesSamsung = [];
    var devicesGoogle = [];
    var devicesHTC = [];
    var devicesMicrosoft = [];

    @foreach ($devicesGraph as $row)
        devicesLabels.push("{{ $row['period'] }}");
        devicesApple.push("{{ $row['Apple'] }}");
        devicesSamsung.push("{{ $row['Samsung'] }}");
        devicesGoogle.push("{{ $row['Google'] }}");
        devicesHTC.push("{{ $row['HTC'] }}");
        devicesMicrosoft.push("{{ $row['Microsoft'] }}");
    @endforeach

    new Chart(
        document.getElementById('mobilesbranding'),
        {
        type: 'line',
        data: {
            labels: devicesLabels,
            datasets: [
                {
                    label: 'Apple',
                    data: devicesApple
                },
                {
                    label: 'Samsung',
                    data: devicesSamsung
                },
                {
                    label: 'Google',
                    data: devicesGoogle
                },
                {
                    label: 'HTC',
                    data: devicesHTC
                },
                {
                    label: 'Microsoft',
                    data: devicesMicrosoft
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
        }
    );

    // Operating system
    var operatingLabels = [];
    var operatingWindows = [];
    var operatingMacintosh = [];
    var operatingLinux = [];

    @foreach ($operatingSystemGraph as $row)
        operatingLabels.push("{{ $row['period'] }}");
        operatingWindows.push("{{ $row['Windows'] }}");
        operatingMacintosh.push("{{ $row['Macintosh'] }}");
        operatingLinux.push("{{ $row['Linux'] }}");
    @endforeach

    new Chart(
        document.getElementById('operatingsystem'),
        {
            type: 'bar',
            data: {
                labels: operatingLabels,
                datasets: [
                    {
                        label: 'Windows',
                        data: operatingWindows
                    },
                    {
                        label: 'Macintosh',
                        data: operatingMacintosh
                    },
                    {
                        label: 'Linux',
                        data: operatingLinux
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        }
    );
</script>
@endpush
