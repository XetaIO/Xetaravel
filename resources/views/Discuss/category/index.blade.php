@extends('layouts.app')
{!! config(['app.title' => 'All Categories']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2 pb-3">

    <div class="row">
        <div class="col-md-3">
            <div class="discuss-new-discussion-btn text-xs-center text-md-left">
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
        <div class="col-md-9">
            <div class="row">
                @forelse ($categories as $category)
                    <div class="col-md-4 mb-1">
                        <div class="discuss-categories-list" style="background-color: {{ $category->color }};">
                            <div class="discuss-categories-header">
                                <h5 class="text-white text-truncate text-md-center">
                                    <a class="text-white" href="{{ route('discuss.category.show', ['slug' => $category->slug, 'id' => $category->getKey()]) }}">
                                        {{ $category->title }}
                                    </a>
                                </h5>
                                <div class="discuss-categories-list-description text-white">
                                    {{ $category->description }}
                                </div>
                            </div>

                            <div class="discuss-categories-footer text-truncate text-white">
                            @if (!is_null($category->lastConversation))
                                <a  class="text-white" href="{{ route('discuss.post.show', ['id' => $category->lastConversation->last_post_id]) }}">
                                    <strong>{{ $category->lastConversation->title }}</strong>

                                    <time datetime="{{ $category->lastConversation->created_at->format('c') }}">
                                        {{ $category->lastConversation->created_at->diffForHumans() }}
                                    </time>
                                </a>
                            @else
                                There's no conversation yet.
                            @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-primary" role="alert">
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                            There's no categories yet.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection