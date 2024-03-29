@extends('layouts.app')
{!! config(['app.title' => 'Blog']) !!}

@push('meta')
    <x-meta title="Blog" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-9 col-span-12 px-3">
            @include('Blog::partials._articles')
        </div>

        <div class="lg:col-span-3 col-span-12 px-3">
            @include('Blog::partials._sidebar')
        </div>

    </div>
</section>
@endsection
