@extends('layouts.admin')
{!! config(['app.title' => 'Manage Permissions']) !!}

@push('meta')
    <x-meta title="Manage Permissions" />
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
            <x-icon name="fas-user-shield" class="h-9 w-9" />
            Manage Permissions
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Manage the permissions.
        </p>
    </hgroup>

    <livewire:admin.permission.permission />

    <livewire:admin.permission.create-permission />

    <livewire:admin.permission.update-permission />
</section>
@endsection
