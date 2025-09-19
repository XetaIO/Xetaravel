<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Roles
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Roles" />
    </x-slot:meta>

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="fas-user-tie" title="Manage Roles" description="Manage the roles." />

        <livewire:admin.permission.role />

        <livewire:admin.permission.create-role />

        <livewire:admin.permission.update-role />
    </section>
</x-Admin::layouts.admin>
