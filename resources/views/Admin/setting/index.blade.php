<x-Admin::layouts.admin>
    <x-slot:title>
        Manage Settings
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Manage Settings" />
    </x-slot:meta>

    @push('scriptsTop')
        @vite('resources/js/easymde.js')
    @endpush

    <x-Admin::breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <x-Admin::heading icon="fas-wrench" title="Manage Settings" description="Manage the settings of the website." />

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md  rounded-lg p-3">
                <x-form.form method="put" action="{{ route('admin.setting.update') }}" class="w-full">
                    @forelse($settings as $setting)
                        @include('Admin.setting.partials.setting-template')
                    @empty
                        <x-alert type="info" class="mt-4" title="Information">
                            There is no settings.
                        </x-alert>
                    @endforelse

                    @if($settings->isNotEmpty())
                        <div class="text-center mb-3">
                            <x-button label="Save" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
                        </div>
                    @endif
                </x-form.form>
            </div>
        </div>
    </section>
</x-Admin::layouts.admin>
