@extends('layouts.error')
{!! config(['app.title' => 'Whoops, something went wrong']) !!}

@push('meta')
  <x-meta title="Whoops, something went wrong" />
@endpush

@section('content')
<div class="container mt-4">
    <div class="error">
        <div class="title font-xeta">
            500
        </div>
        <div class="description mb-1">
            Whoops, looks like something went wrong.
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