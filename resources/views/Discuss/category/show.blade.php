@extends('layouts.app')
{!! config(['app.title' => e($category->title)]) !!}

@push('meta')
  <x-meta title="{{ e($category->title) }}" />
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
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>


<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-3 col-span-12 px-3">
            <div class="">
                <a href="https://xetaravel.com/discuss/conversation/create" class="btn btn-primary gap-2">
                    <i class="fa-solid fa-pencil"></i>
                    Start a Discussion
                </a>
            </div>
            @include('Discuss::partials._sidebar')
        </div>
        <div class="lg:col-span-9 col-span-12 px-3">
            <livewire:discuss.conversation :category="$category->getKey()" />
        </div>
     </div>
</section>
@endsection