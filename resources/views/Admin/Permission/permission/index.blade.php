<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Permissions
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Permissions" />
    </x-slot:meta>

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="fas-user-shield" title="Manage Permissions" description="Manage the permissions." />

        <livewire:admin.permission.permission />

        <livewire:admin.permission.create-permission />

        <livewire:admin.permission.update-permission />
    </section>
</x-Admin::layouts.admin>
