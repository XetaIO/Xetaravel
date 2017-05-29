@extends('layouts.app')
{!! config(['app.title' => $article->title]) !!}

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
<div class="container pb-1 pt-4">
    <div class="blog-header mt-2">
        <div class="container">
            <h1 class="blog-title">
                {{ $article->title }}
            </h1>
        </div>
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">

        <div class="col-md-9">
            <div class="blog-post">
                <div class="blog-post-meta">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <time datetime="{{ $article->created_at->format('c') }}" title="{{ $article->created_at->format('c') }}" data-toggle="tooltip">
                                {{ $article->created_at }}
                            </time>
                        </li>
                        <li class="list-inline-item">
                            <i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" title="Category"></i>
                            <a href="{{ $article->category->category_url }}">
                                {{ $article->category->title }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    {!! Markdown::convertToHtml($article->content) !!}
                </div>
            </div>

            <hr />
            <div class="card card-outline-primary">
                <div class="card-block" style="display: flex;">
                    <div class="card-left" style="padding-right: 15px;">
                        <a href="{{ $article->user->profile_url }}">
                            <img class="card-media rounded-circle" src="{{ asset($article->user->avatar_small) }}" alt="Avatar" height="64px" width="64px">
                        </a>
                    </div>
                    <div class="card-body" style="flex: 1;">
                        <h4 class="card-title text-truncate">
                            <a href="{{ $article->user->profile_url }}">
                                {{ $article->user->username }}
                            </a>
                        </h4>

                        <p class="card-subtitle text-muted">
                            {!! Markdown::convertToHtml($article->user->signature) !!}
                        </p>
                    </div>
                </div>
            </div>

            @if ($comments->isNotEmpty())
                <h4 class="mt-3 font-xeta">
                    {{ $article->comment_count }} Comments
                </h4>

                <comments :comments="{{ $comments->getCollection()->toJson() }}"></comments>

                <div class="col-md 12 text-xs-center">
                    {{ $comments->render() }}
                </div>

            @elseif (Auth::user())
                <hr />
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    There's not comment yet. Post the first reply !
                </div>
            @endif

            <hr />
            @if (Auth::user())

                <div class="comment mb-2">
                    <div class="comment-media hidden-sm-down">
                        {{ Html::image(Auth::user()->avatar_small, 'Avatar', ['class' => 'rounded-circle', 'height' => '80px', 'width' => '80px']) }}
                    </div>
                    <div class="comment-content">
                        {!! Form::open(['route' => 'blog.comment.create']) !!}
                            {!! Form::hidden('article_id', $article->id) !!}

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
            @endif

        </div>

        <div class="col-md-3">
            @include('partials.blog._sidebar')
        </div>

    </div>
</div>
@endsection
