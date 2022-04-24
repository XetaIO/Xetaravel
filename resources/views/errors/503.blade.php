@extends('layouts.error')
{!! config(['app.title' => 'Website in maintenance']) !!}

@push('meta')
  <x-meta title="Website in maintenance" />
@endpush

@section('content')
<div class="container mt-4 pb-4">
    <div class="error">
        <div class="title font-xeta">
            503
        </div>
        <div class="description mb-1">
            The website is in maintenance, try again later.
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