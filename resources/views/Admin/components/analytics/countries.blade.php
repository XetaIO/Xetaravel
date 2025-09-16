@props([
    'countries' => [],
])


<x-Admin::analytics.stats.list primaryLabel="Countries" secondaryLabel="Which Countries your visitors come from">
    @forelse($countries as $country)
        <x-Admin::analytics.stats.item
                label="{{ $country['name'] }}"
                count="{{ $country['count'] }}"
                percentage="{{ $country['percentage'] }}"
                imgSrc="https://www.worldatlas.com/r/w236/img/flag/{{$country['code']}}-flag.jpg"
        />
    @empty
        <p class="text-sm text-gray-500 text-center py-5">No countries</p>
    @endforelse
</x-Admin::analytics.stats.list>
