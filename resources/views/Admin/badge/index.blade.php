<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Badges
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Badges" />
    </x-slot:meta>

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="far-id-badge" title="Manage Badges" description="Manage the badges of the website." />

        <livewire:admin.badge.badge />

        <livewire:admin.badge.create-badge />

        <livewire:admin.badge.update-badge />

    </section>
</x-Admin::layouts.admin>
