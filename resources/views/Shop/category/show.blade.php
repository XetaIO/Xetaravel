@extends('layouts.app')
{!! config(['app.title' => 'Category : ' . e($category->title)]) !!}

@push('meta')
    <x-meta title="Category : {{ e($category->title) }}" />
@endpush

@section('content')
<div class="container pb-1 pt-4">
    <div class="shop-title mt-2">
        {{ $category->title }}
        <p class="lead text-muted">
            {{ $category->description }}
        </p>
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2 pb-4">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                @include('Shop::partials._items')
            </div>
        </div>

        <div class="col-md-3">
            @include('Shop::partials._sidebar')
        </div>

    </div>
</div>
@endsection
