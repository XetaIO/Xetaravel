@extends('layouts.admin')
{!! config(['app.title' => 'Manage Roles']) !!}

@push('meta')
    <x-meta title="Manage Roles" />
@endpush

@section('content')
<section class="m-3 lg:m-10">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="m-3 lg:m-10">
    <hgroup class="text-center px-5 pb-5">
        <h1 class="text-4xl font-xetaravel">
            Manage Roles
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Manage the roles of the site.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
            <livewire:admin.roles.roles />
        </div>
    </div>
</section>
@endsection
