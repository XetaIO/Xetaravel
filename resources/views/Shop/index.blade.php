@extends('layouts.app')
{!! config(['app.title' => 'Shop']) !!}

@push('meta')
    <x-meta title="Shop" />
@endpush

@section('content')
<div class="container pb-1 pt-4">
    <div class="shop-title mt-2">
        Xeticons Shop
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2 pb-4">

    <div class="row">
        <div class="col-lg-9">
            @include('Shop::partials._items')
        </div>

        <div class="col-lg-3">
            @include('Shop::partials._sidebar')
        </div>

    </div>
</div>
@endsection
