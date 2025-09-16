@push('scripts')
    @vite('resources/js/chart.js')

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
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
        });
    </script>
@endpush
