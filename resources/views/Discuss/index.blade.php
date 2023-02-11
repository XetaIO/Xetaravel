@extends('layouts.app')
{!! config(['app.title' => 'Discuss']) !!}

@push('meta')
  <x-meta title="Discuss" />
@endpush

@push('style')
@livewireStyles
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 lg:mx-0">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>


<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-3 col-span-12 mx-3 lg:mx-0">
            <div class="mb-5">
                <a href="{{ route('discuss.conversation.create') }}" class="btn btn-primary gap-2">
                    <i class="fa-solid fa-pencil"></i>
                    Start a Discussion
                </a>
            </div>
            @include('Discuss::partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <livewire:discuss.conversation />
        </div>
     </div>
</section>
@endsection