@extends('layouts.admin')
{!! config(['app.title' => 'Manage Users']) !!}

@push('meta')
    <x-meta title="Manage Users" />
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
            <x-icon name="fas-users" class="h-9 w-9" />
            Manage Users
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Manage the users of the website.
        </p>
    </hgroup>

    <livewire:admin.user.user />

    <livewire:admin.user.update-user />

</section>
@endsection
