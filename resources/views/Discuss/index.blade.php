@extends('layouts.app')
{!! config(['app.title' => 'Discuss']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-module">
                <div class="discuss-new-discussion-btn text-truncate">
                    {{ link_to(
                        route('discuss.conversation.create'),
                        '<i class="fa fa-pencil"></i> Start a Discussion',
                        ['class' => 'btn btn-primary'],
                        true,
                        false
                    ) }}
                </div>

                @include('Discuss::partials._sidebar')
            </div>
        </div>
        <div class="col-md-9">
            @include('Discuss::partials._conversations')
        </div>
    </div>
</div>
@endsection