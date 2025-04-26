@extends('layouts.admin')
{!! config(['app.title' => 'Manage Roles']) !!}

@push('meta')
    <x-meta title="Manage Roles" />
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
            <x-icon name="fas-user-tie" class="h-9 w-9" />
            Manage Roles
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Manage the roles.
        </p>
    </hgroup>

    <livewire:admin.permission.role />

    <livewire:admin.permission.create-role />

    <livewire:admin.permission.update-role />
</section>
@endsection
