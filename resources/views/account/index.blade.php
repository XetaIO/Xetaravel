<x-layouts.app>
    <x-slot:title>
        My account
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="My account" />
    </x-slot:meta>

@push('scriptsTop')
    @vite('resources/js/highlight.js')
    @vite('resources/js/easymde.js')

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // HighlightJS
            hljs.highlightAll();
        });
    </script>
@endpush

    <section class="lg:container mx-auto mt-12 mb-5">
        <div class="grid grid-cols-1">
            <div class="col-span-12 mx-3 lg:mx-0">
                {!! $breadcrumbs->render() !!}
            </div>
        </div>
    </section>

    <section class="lg:container mx-auto pt-4 mb-5">
        <div class="grid grid-cols-12 gap-8">

            <div class="lg:col-span-3 col-span-12 mx-3 lg:mx-0">
                @include('user.partials._sidebar')
            </div>

            <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
                <livewire:user.update-account />
            </div>
        </div>
    </section>
</x-layouts.app>
