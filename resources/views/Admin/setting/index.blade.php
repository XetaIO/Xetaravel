@extends('layouts.admin')
{!! config(['app.title' => 'Manage Settings']) !!}

@push('meta')
    <x-meta title="Manage Settings" />
@endpush

@push('scriptsTop')
    @vite('resources/js/easymde.js')
@endpush

@section('content')
    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-1">
            <div class="col-span-12">
                {!! $breadcrumbs->render() !!}
            </div>
        </div>
    </section>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                <x-icon name="fas-wrench" class="h-9 w-9" />
                Manage Settings
            </h1>
            <p class="text-gray-400 dark:text-gray-500">
                Manage the settings of the website.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md  rounded-lg p-3">
                <x-form method="put" action="{{ route('admin.setting.update') }}" class="w-full">
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
                </x-form>
            </div>
        </div>

    </section>
@endsection
