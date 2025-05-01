@extends('layouts.admin')
{!! config(['app.title' => 'Manage Articles']) !!}

@push('meta')
    <x-meta title="Manage Articles" />
@endpush


@push('scriptsTop')
    @vite('resources/js/flatpickr.js')
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
            <x-icon name="far-newspaper" class="h-9 w-9" />
            Manage Articles
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Manage the blog articles.
        </p>
    </hgroup>

    <livewire:admin.blog.article />

    <livewire:admin.blog.create-article />

    <livewire:admin.blog.update-article />
</section>
@endsection
