@extends('layouts.admin')
{!! config(['app.title' => 'Manage Items']) !!}

@push('meta')
    <x-meta title="Manage Items" />
@endpush

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Manage Items
        </h5>
        <div class="card-block">

            <livewire:admin.shop.item />

        </div>


    </div>
</div>
@endsection
