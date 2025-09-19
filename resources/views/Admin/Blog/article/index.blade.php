<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Articles
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Articles" />
    </x-slot:meta>

    @push('scriptsTop')
        @vite('resources/js/flatpickr.js')
        @vite('resources/js/easymde.js')
    @endpush

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="far-newspaper" title="Manage Articles" description="Manage the blog articles." />

        <livewire:admin.blog.article />

        <livewire:admin.blog.create-article />

        <livewire:admin.blog.update-article />
    </section>
</x-Admin::layouts.admin>
