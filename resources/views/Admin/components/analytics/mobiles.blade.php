<div class="grid grid-cols-12 gap-6 mb-7">
    <div class="col-span-12 mb-2 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
        <div class="text-2xl">
            Mobile Branding Analytics
        </div>
        <span class="text-sm opacity-60">Which mobile your visitors come from</span>
        <div class="chart-container relative min-h-[250px] sm:min-h-[300px] md:min-h-[400px] lg:min-h-[250px] xl:min-h-[350px] 2xl:min-h-[400px] w-full">
            <canvas id="mobilesBranding"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Mobiles Devices
            new Chart(
                document.getElementById('mobilesBranding'),
                {
                    type: 'line',
                    data: {
                        labels: @json($mobileDevices->pluck('period')),
                        datasets: [
                            {
                                label: 'Apple',
                                data: @json($mobileDevices->pluck('Apple'))
                            },
                            {
                                label: 'Samsung',
                                data: @json($mobileDevices->pluck('Samsung'))
                            },
                            {
                                label: 'Google',
                                data: @json($mobileDevices->pluck('Google'))
                            },
                            {
                                label: 'HTC',
                                data: @json($mobileDevices->pluck('HTC'))
                            },
                            {
                                label: 'Huawei',
                                data: @json($mobileDevices->pluck('Huawei'))
                            },
                            {
                                label: 'Microsoft',
                                data: @json($mobileDevices->pluck('Microsoft'))
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
