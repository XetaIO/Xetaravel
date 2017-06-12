@extends('layouts.app')
{!! config(['app.title' => $thread->title]) !!}

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $config = [
            'id' => 'commentEditor',
            'height' => '350'
        ];
    @endphp

    @include('editor/partials/_comment', $config)


    <script src="{{ mix('js/highlight.min.js') }}"></script>
    <script type="text/javascript">
        /* HighlightJS */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="discuss-thread-header-container pb-1 pt-4">
    <div class="blog-header mt-2">
        <div class="container text-xs-center">
            <ul class="discuss-thread-header-badges d-inline-block">
                @if ($thread->is_pinned)
                    <li class="discuss-thread-header-badges-item">
                        <span class="tag tag-info" data-toggle="tooltip" title="Pinned">
                            <i class="fa fa-thumb-tack"></i>
                        </span>
                    </li>
                @endif

                @if ($thread->is_locked)
                    <li class="discuss-thread-header-badges-item">
                        <span class="tag tag-primary" data-toggle="tooltip" title="Locked">
                            <i class="fa fa-lock"></i>
                        </span>
                    </li>
                @endif
            </ul>

            @if ($thread->is_solved)
                <div class="discuss-thread-header-categories tag-group">
                    <a href="{{ route('discuss.category.show', ['slug' => $thread->category->slug, 'id' =>$thread->category->getKey()]) }}" class="tag tag-default text-white" style="background-color: {{ $thread->category->color }};">
                        {{ $thread->category->title }}
                    </a>
                    <span class="tag tag-success text-white">
                        Solved
                    </span>
                </div>
            @else
                <div class="discuss-thread-header-categories">
                    <a href="{{ route('discuss.category.show', ['slug' => $thread->category->slug, 'id' =>$thread->category->getKey()]) }}" class="tag tag-default text-white" style="background-color: {{ $thread->category->color }};">
                        {{ $thread->category->title }}
                    </a>
                </div>
            @endif
            <h2 class="text-truncate">
                {{ $thread->title }}
            </h2>
        </div>
    </div>
</div>
<hr class="mt-0" />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">
        <div class="col-md-3">
            @include('Discuss::partials._sidebar')
        </div>
        <div class="col-md-9 mb-3">
            @include(
                'Discuss::partials._thread-post',
                [
                    'post' => $thread,
                    'thread' => $thread,
                    'solved' => false,
                    'comment' => false,
                    'is_thread' => true
                ]
            )

            @if ($thread->is_solved)
                @include(
                    'Discuss::partials._thread-post',
                    [
                        'post' => $thread->solvedComment,
                        'thread' => $thread,
                        'solved' => true,
                        'comment' => false,
                        'is_thread' => false
                    ]
                )
            @endif

            @forelse ($commentsWithLogs as $comment)
                @include(
                    'Discuss::partials._thread-post',
                    [
                        'post' => $comment,
                        'thread' => $thread,
                        'solved' => false,
                        'comment' => true,
                        'is_thread' => false
                    ]
                )
            @empty
                @if (!$thread->is_solved && !$thread->is_locked)
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There're no comments yet, post the first reply !
                    </div>
                @endif
            @endforelse

            <div class="col-md 12 text-xs-center">
                {{ $comments->render() }}
            </div>

            @if ($thread->is_locked)
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    This thread is closed, you can not reply !
                </div>
            @else
                @auth
                    <div class="discuss-thread-comment mb-2">
                        <div class="discuss-thread-comment-media float-xs-left hidden-sm-down">
                            {{ Html::image(Auth::user()->avatar_small, 'Avatar', ['class' => 'rounded-circle img-thumbnail']) }}
                        </div>
                        <div class="discuss-thread-comment-content">
                            {!! Form::open(['route' => 'blog.comment.create']) !!}
                                {!! Form::hidden('thread_id', $thread->id) !!}

                                {!! Form::bsTextarea('content', false, old('message'), [
                                    'placeholder' => 'Your message here...',
                                    'required' => 'required',
                                    'editor' => 'commentEditor',
                                    'style' => 'display:none;'
                                ]) !!}

                                {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i> Comment', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        You need to be logged in to comment to this article !
                    </div>
                @endauth
            @endif
        </div>
    </div>
</div>
@endsection