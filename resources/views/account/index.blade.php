@extends('layouts.app')
{!! config(['app.title' => 'My account']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">
    @include('elements.flash')

    <div class="row">
        <div class="col-md-3">
            @include('account._sidebar')
        </div>
        <div class="col-md-9">

        </div>
    </div>
</div>
@endsection
