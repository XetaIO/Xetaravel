@push('scripts')
    @vite('resources/js/chart.js')

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Visitors
            new Chart(
                document.getElementById('visitors'),
                {
                    type: 'line',
                    data: {
                        labels: @json($visitorsData->pluck('date')),
                        datasets: [
                            {
                                label: 'Visitors',
                                data: @json($visitorsData->pluck('sessions'))
                            },
                            {
                                label: 'Page Views',
                                data: @json($visitorsData->pluck('screenPageViews'))
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
            new Chart(
                document.getElementById('mobilesbranding'),
                {
                    type: 'line',
                    data: {
                        labels: @json($devicesGraph->pluck('period')),
                        datasets: [
                            {
                                label: 'Apple',
                                data: @json($devicesGraph->pluck('Apple'))
                            },
                            {
                                label: 'Samsung',
                                data: @json($devicesGraph->pluck('Samsung'))
                            },
                            {
                                label: 'Google',
                                data: @json($devicesGraph->pluck('Google'))
                            },
                            {
                                label: 'HTC',
                                data: @json($devicesGraph->pluck('HTC'))
                            },
                            {
                                label: 'Huawei',
                                data: @json($devicesGraph->pluck('Huawei'))
                            },
                            {
                                label: 'Microsoft',
                                data: @json($devicesGraph->pluck('Microsoft'))
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
            new Chart(
                document.getElementById('browsers'),
                {
                    type: 'doughnut',
                    data: {
                        labels: @json($browsersData->map(fn ($data) => $data['browser'])),
                        datasets: [
                            {
                                label: 'Browsers',
                                data: @json($browsersData->map(fn ($data) => $data['screenPageViews'])),
                                backgroundColor: @json($browsersData->map(fn ($data) => $data['color']))
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
            new Chart(
                document.getElementById('operatingsystem'),
                {
                    type: 'bar',
                    data: {
                        labels: @json($operatingSystemGraph->pluck('period')),
                        datasets: [
                            {
                                label: 'Windows',
                                data: @json($operatingSystemGraph->pluck('Windows'))
                            },
                            {
                                label: 'Macintosh',
                                data: @json($operatingSystemGraph->pluck('Macintosh'))
                            },
                            {
                                label: 'Linux',
                                data: @json($operatingSystemGraph->pluck('Linux'))
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

        });
    </script>
@endpush
