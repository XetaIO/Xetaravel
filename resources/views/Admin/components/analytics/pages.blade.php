@props([
    'pages' => [],
])

<x-Admin::analytics.stats.list primaryLabel="Pages" secondaryLabel="Which Pages are the most views">
    @forelse($pages as $page)
        <x-Admin::analytics.stats.item
            label="{{ $page['path'] }}"
            count="{{ $page['views'] }}"
            percentage="{{ $page['percentage'] }}"
        />
    @empty
        <p class="text-sm text-gray-500 text-center py-5">No pages</p>
    @endforelse
</x-Admin::analytics.stats.list>
