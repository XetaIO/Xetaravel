@props([
    'referrers' => [],
])

<x-Admin::analytics.stats.list primaryLabel="Referrers" secondaryLabel="Where your visitors come from">
    @forelse($referrers as $referrer)
        <x-Admin::analytics.stats.item
            label="{{ $referrer['domain'] }}"
            count="{{ $referrer['visits'] }}"
            percentage="{{ $referrer['percentage'] }}"
        />
    @empty
        <p class="text-sm text-gray-500 text-center py-5">No referrers</p>
    @endforelse
</x-Admin::analytics.stats.list>
