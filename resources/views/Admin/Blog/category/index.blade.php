<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Categories
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Categories" />
    </x-slot:meta>

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="fas-tags" title="Manage Categories" description="Manage the blog categories." />

        <livewire:admin.blog.category />

        <livewire:admin.blog.create-category />

        <livewire:admin.blog.update-category />
    </section>
</x-Admin::layouts.admin>
