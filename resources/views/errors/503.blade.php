@extends('layouts.app')
{!! config(['app.title' => 'Website in maintenance']) !!}

@push('meta')
  <x-meta title="Website in maintenance" />
@endpush

@section('content')
<div class="lg:container mx-auto mt-12 mb-5">
    <div class="text-center">
        <h1 class="text-[14rem] font-bold text-error mb-7">
            503
        </h1>
        <div class="text-xl mb-12">
            The website is in maintenance, try again later.
        </div>
        <div class="mb-8">
            <a class="btn btn-primary  gap-2" href="{{ route('page.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Home
            </a>
        </div>
    </div>
</div>
@endsection
