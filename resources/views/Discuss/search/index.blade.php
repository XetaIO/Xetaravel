@extends('layouts.app')
{!! config(['app.title' => 'Search : ' . e($search)]) !!}

@push('meta')
  <x-meta title="Search : {{ e($search) }}" />
@endpush

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2 pb-4">

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
            <div class="row">
                <div class="offset-md-2 col-md-8">
                    <!-- Search form -->
                    <div class="input-group mb-1">
                    {!! Form::open(['route' => 'discuss.search.index', 'method' => 'post', 'style' => 'display: contents;']) !!}
                        <input placeholder="Search..." required="required" name="search" type="text" id="search" class="form-control" value="{{ $search }}">

                        {!! Form::button('<i class="fa fa-search" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'input-group-addon btn btn-primary']) !!}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @include('Discuss::partials._conversations')
        </div>
    </div>
</div>
@endsection