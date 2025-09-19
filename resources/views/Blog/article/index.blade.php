<x-layouts.app>
    <x-slot:title>
        Blog
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Blog" />
    </x-slot:meta>

    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="lg:container mx-auto pt-4 mb-5">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-9 col-span-12 px-3">
                @include('Blog::partials._articles')
            </div>

            <div class="lg:col-span-3 col-span-12 px-3">
                @include('Blog::partials._sidebar')
            </div>
        </div>
    </section>
</x-layouts.app>
