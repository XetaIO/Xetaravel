@extends('layouts.admin')
{!! config(['app.title' => 'Manage Categories']) !!}

@push('meta')
    <x-meta title="Manage Categories" />
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
            <x-icon name="fas-tags" class="h-9 w-9" />
            Manage Categories
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Manage the blog categories.
        </p>
    </hgroup>

    <livewire:admin.blog.category />

    <livewire:admin.blog.create-category />

    <livewire:admin.blog.update-category />
</section>
@endsection
