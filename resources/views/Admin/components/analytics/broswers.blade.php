@props([
    'browsers' => [],
])

@php
    if (!function_exists('getBrowserImage')) {
        function getBrowserImage($browser): string {
            return match(strtolower($browser)){
                'chrome' =>  asset('vendor/request-analytics/browsers/chrome.png'),
                'firefox' => asset('vendor/request-analytics/browsers/firefox.png'),
                'safari' => asset('vendor/request-analytics/browsers/safari.png'),
                'edge' => asset('vendor/request-analytics/browsers/ms-edge.png'),
                default => asset('vendor/request-analytics/browsers/unknown.png'),
            };
        }
    }
@endphp

<x-Admin::analytics.stats.list primaryLabel="Browser" secondaryLabel="Which Browsers is used">
    @forelse($browsers as $browser)
        <x-Admin::analytics.stats.item
            label="{{ $browser['browser'] }}"
            count="{{ $browser['count'] }}"
            percentage="{{ $browser['percentage'] }}"
            imgSrc="{{ getBrowserImage($browser['browser']) }}"
        />
    @empty
        <p class="text-sm text-gray-500 text-center py-5">No browsers</p>
    @endforelse
</x-Admin::analytics.stats.list>
