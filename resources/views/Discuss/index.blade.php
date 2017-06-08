@extends('layouts.app')
{!! config(['app.title' => 'Discuss']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('Discuss::partials._sidebar')
        </div>
        <div class="col-md-9">
            @include('Discuss::partials._threads')
        </div>
    </div>
</div>
@endsection