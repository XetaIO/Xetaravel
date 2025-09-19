<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Categories
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Categories" />
    </x-slot:meta>

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="fas-tags" title="Manage Categories" description="Manage the discuss categories." />

        <livewire:admin.discuss.category />

        <livewire:admin.discuss.create-category />

        <livewire:admin.discuss.update-category />
    </section>
</x-Admin::layouts.admin>
