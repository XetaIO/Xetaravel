@extends('layouts.app')
{!! config(['app.title' => 'Discuss']) !!}

@push('meta')
  <x-meta title="Discuss" />
@endpush

@push('scriptsTop')
    @vite('resources/js/highlight.js')
    @vite('resources/js/easymde.js')

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // HighlightJS
            hljs.highlightAll();
        });
    </script>
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
            @can('create', \Xetaravel\Models\DiscussConversation::class)
                <x-button icon="fas-pencil" label="Start a Discussion" class="btn-primary gap-2 conversationCreateButton mb-5" />
                <livewire:discuss.create-conversation />
            @endcan

            @include('Discuss::partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <livewire:discuss.conversation />
        </div>
     </div>
</section>
@endsection
