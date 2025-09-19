<x-layouts.app>
    <x-slot:title>
        Category : {{ $category->title }}
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Category : {{ e($category->title) }}" />
    </x-slot:meta>

    <section class="lg:container mx-auto mt-12 mb-5  overflow-hidden">
        <div class="grid grid-cols-1">
            <div class="col-span-12 mx-3 ">
                {!! $breadcrumbs->render() !!}
            </div>
        </div>
    </section>

    <section class="lg:container mx-auto  overflow-hidden">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                {{ $category->title }}
            </h1>
            <p class="text-gray-400 dark:text-gray-500">
                {{ $category->description }}
            </p>
        </hgroup>
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
