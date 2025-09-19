<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Users
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Users" />
    </x-slot:meta>

    @push('scriptsTop')
        @vite('resources/js/easymde.js')
    @endpush

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="fas-users" title="Manage Users" description="Manage the users of the website." />

        <livewire:admin.user.user />

        <livewire:admin.user.update-user />

    </section>
</x-Admin::layouts.admin>
