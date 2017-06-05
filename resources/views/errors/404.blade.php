@extends('layouts.error')
{!! config(['app.title' => 'Not found']) !!}

@section('content')
<div class="container mt-4">
    <div class="error">
        <div class="title font-xeta">
            404
        </div>
        <div class="description mb-1">
            The page you're looking for doesn't exist.
        </div>
        <div class="link">
            {!! link_to(
                route('page.index'),
                '<i class="fa fa-home" aria-hidden="true"></i> Accueil',
                ['class' => 'btn btn-outline-primary'],
                true,
                false
            ) !!}
        </div>
    </div>
</div>
@endsection